<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DataRequest;
use App\Models\Opd;
use App\Models\ReportHistory;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DataRequestController extends Controller
{
    /**
     * Display a listing of the user's data requests.
     */
    public function index(Request $request)
    {
        $query = DataRequest::where('user_id', auth()->id())
            ->with(['opd'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $dataRequests = $query->paginate(10);

        return view('user.data-requests.index', compact('dataRequests'));
    }

    /**
     * Show the form for creating a new data request.
     */
    public function create()
    {
        $opdList = Opd::where('is_active', true)
            ->orderBy('nama')
            ->get();

        $formatOptions = [
            'excel' => 'Excel (.xlsx)',
            'csv' => 'CSV (.csv)',
            'pdf' => 'PDF (.pdf)',
            'json' => 'JSON (.json)',
        ];

        return view('user.data-requests.create', compact('opdList', 'formatOptions'));
    }

    /**
     * Store a newly created data request in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_data' => 'required|string|max:255',
            'opd_id' => 'nullable|uuid|exists:opd,id',
            'sumber_data' => 'nullable|string|max:255',
            'tahun_periode' => 'nullable|string|max:50',
            'tujuan_penggunaan' => 'required|string|min:20',
            'deskripsi' => 'nullable|string',
            'format_data' => 'required|array|min:1',
            'format_data.*' => 'in:excel,csv,pdf,json',
            'tanggal_dibutuhkan' => 'nullable|date|after:today',
        ], [
            'nama_data.required' => 'Nama data yang diminta wajib diisi.',
            'tujuan_penggunaan.required' => 'Tujuan penggunaan data wajib diisi.',
            'tujuan_penggunaan.min' => 'Tujuan penggunaan minimal 20 karakter.',
            'format_data.required' => 'Pilih minimal satu format data.',
            'tanggal_dibutuhkan.after' => 'Tanggal dibutuhkan harus setelah hari ini.',
        ]);

        try {
            DB::beginTransaction();

            $dataRequest = DataRequest::create([
                'user_id' => auth()->id(),
                'opd_id' => $validated['opd_id'] ?? null,
                'nama_data' => $validated['nama_data'],
                'sumber_data' => $validated['sumber_data'] ?? null,
                'tahun_periode' => $validated['tahun_periode'] ?? null,
                'tujuan_penggunaan' => $validated['tujuan_penggunaan'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'format_data' => $validated['format_data'],
                'tanggal_dibutuhkan' => $validated['tanggal_dibutuhkan'] ?? null,
                'status' => 'diajukan',
            ]);

            ReportHistory::createForDataRequest($dataRequest->id, 'Permintaan data berhasil dikirim', auth()->id());

            // Send notification
            $notificationService = app(NotificationService::class);
            $notificationService->notifyDataRequestSubmitted($dataRequest);

            DB::commit();

            return redirect()->route('user.data-requests.show', $dataRequest)
                ->with('success', 'Permintaan data berhasil diajukan dengan nomor tiket: ' . $dataRequest->ticket_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified data request.
     */
    public function show(DataRequest $dataRequest)
    {
        // Ensure user can only view their own requests
        if ($dataRequest->user_id !== auth()->id()) {
            abort(403);
        }

        $dataRequest->load(['opd', 'histories.user', 'handler']);

        return view('user.data-requests.show', compact('dataRequest'));
    }

    /**
     * Download the data file.
     */
    public function download(DataRequest $dataRequest)
    {
        // Ensure user can only download their own data
        if ($dataRequest->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if data is available
        if ($dataRequest->status !== 'tersedia' || empty($dataRequest->file_path)) {
            return back()->with('error', 'Data belum tersedia untuk diunduh.');
        }

        // Check if link expired
        if ($dataRequest->isExpired()) {
            return back()->with('error', 'Link download sudah kadaluarsa.');
        }

        // Increment download count
        $dataRequest->incrementDownloadCount();

        return Storage::disk('public')->download($dataRequest->file_path, $dataRequest->file_name);
    }
}
