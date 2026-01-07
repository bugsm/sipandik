<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\DataRequestsExport;
use App\Models\DataRequest;
use App\Services\FileUploadService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DataRequestController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Display a listing of data requests.
     */
    public function index(Request $request)
    {
        $query = DataRequest::with(['user', 'opd', 'handler'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('nama_data', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $dataRequests = $query->paginate(15);

        return view('admin.data-requests.index', compact('dataRequests'));
    }

    /**
     * Display the specified data request.
     */
    public function show(DataRequest $dataRequest)
    {
        $dataRequest->load(['user', 'opd', 'histories.user', 'handler']);
        
        return view('admin.data-requests.show', compact('dataRequest'));
    }

    /**
     * Update the status of data request.
     */
    public function updateStatus(Request $request, DataRequest $dataRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:diajukan,diproses,tersedia,ditolak',
            'catatan' => 'nullable|string|max:500',
        ]);

        $oldStatus = $dataRequest->status;
        
        $dataRequest->update([
            'status' => $validated['status'],
            'catatan_admin' => $validated['catatan'] ?? $dataRequest->catatan_admin,
            'handled_by' => auth()->id(),
            'handled_at' => now(),
        ]);

        // Create history
        $dataRequest->histories()->create([
            'status_lama' => $oldStatus,
            'status_baru' => $validated['status'],
            'aksi' => 'update_status',
            'keterangan' => 'Status diubah dari ' . $oldStatus . ' menjadi ' . $validated['status'] .
                          ($validated['catatan'] ? '. Catatan: ' . $validated['catatan'] : ''),
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Send notification
        $notificationService = app(\App\Services\NotificationService::class);
        $notificationService->notifyDataRequestStatusUpdate($dataRequest);

        return back()->with('success', 'Status permintaan data berhasil diperbarui.');
    }

    /**
     * Upload data file for the request.
     */
    public function uploadData(Request $request, DataRequest $dataRequest)
    {
        $validated = $request->validate([
            'data_file' => 'required|file|mimes:xlsx,xls,csv,pdf,json,zip|max:51200', // 50MB max
            'catatan' => 'nullable|string|max:500',
        ]);

        // Upload file
        $fileInfo = $this->fileUploadService->uploadDataFile($request->file('data_file'), $dataRequest);

        // Update data request
        $dataRequest->update([
            'status' => 'tersedia',
            'file_path' => $fileInfo['file_path'],
            'file_name' => $fileInfo['file_name'],
            'file_size' => $fileInfo['file_size'],
            'catatan_admin' => $validated['catatan'] ?? $dataRequest->catatan_admin,
            'handled_by' => auth()->id(),
            'handled_at' => now(),
            'expired_at' => now()->addDays(30), // Link expires in 30 days
        ]);

        // Create history
        $dataRequest->histories()->create([
            'status_lama' => $dataRequest->status,
            'status_baru' => 'tersedia',
            'aksi' => 'upload_data',
            'keterangan' => 'Data telah diupload: ' . $fileInfo['file_name'],
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Send notification (notifyDataRequestStatusUpdate handles availability check internally or we can call specific one)
        // Here notifyDataRequestStatusUpdate is enough as it checks for 'tersedia' status and sends DataAvailable 
        // OR we might want to be explicit. Let's rely on notifyDataRequestStatusUpdate logic I wrote which calls DataAvailable if status is available
        $notificationService = app(\App\Services\NotificationService::class);
        $notificationService->notifyDataRequestStatusUpdate($dataRequest);

        return back()->with('success', 'Data berhasil diupload. Pengguna dapat mengunduh data sekarang.');
    }

    /**
     * Export data requests.
     */
    public function export($format)
    {
        if (!in_array($format, ['xlsx', 'pdf'])) {
            abort(404);
        }

        $date = now()->format('d-m-Y');

        if ($format === 'xlsx') {
            return Excel::download(new DataRequestsExport, 'laporan-permintaan-data-' . $date . '.xlsx');
        }

        if ($format === 'pdf') {
            $dataRequests = DataRequest::with(['user', 'opd'])
                ->latest()
                ->get();

            $pdf = Pdf::loadView('exports.data-requests-pdf', [
                'dataRequests' => $dataRequests,
                'date' => now()->translatedFormat('d F Y')
            ]);
            
            $pdf->setPaper('a4', 'landscape');

            return $pdf->download('laporan-permintaan-data-' . $date . '.pdf');
        }
    }
}
