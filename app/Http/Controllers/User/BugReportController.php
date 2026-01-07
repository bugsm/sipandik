<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\BugReport;
use App\Models\ReportHistory;
use App\Models\VulnerabilityType;
use App\Services\FileUploadService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BugReportController extends Controller
{
    protected FileUploadService $fileUploadService;
    protected NotificationService $notificationService;

    public function __construct(FileUploadService $fileUploadService, NotificationService $notificationService)
    {
        $this->fileUploadService = $fileUploadService;
        $this->notificationService = $notificationService;
    }

    /**
     * Display a listing of the user's bug reports.
     */
    public function index(Request $request)
    {
        $query = BugReport::where('user_id', auth()->id())
            ->with(['application.opd', 'vulnerabilityType'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bugReports = $query->paginate(10);

        return view('user.bug-reports.index', compact('bugReports'));
    }

    /**
     * Show the form for creating a new bug report.
     */
    public function create()
    {
        $applications = Application::with('opd')
            ->where('is_active', true)
            ->orderBy('nama')
            ->get();

        $vulnerabilityTypes = VulnerabilityType::where('is_active', true)
            ->orderBy('urutan')
            ->get();

        return view('user.bug-reports.create', compact('applications', 'vulnerabilityTypes'));
    }

    /**
     * Store a newly created bug report in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'application_id' => 'required|uuid|exists:applications,id',
            'vulnerability_type_id' => 'required|uuid|exists:vulnerability_types,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:20',
            'langkah_reproduksi' => 'nullable|string',
            'dampak' => 'nullable|string',
            'url_terkait' => 'nullable|url|max:255',
            'tanggal_kejadian' => 'required|date|before_or_equal:today',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,log,zip|max:10240',
        ], [
            'application_id.required' => 'Pilih aplikasi yang dilaporkan.',
            'vulnerability_type_id.required' => 'Pilih jenis kerentanan.',
            'judul.required' => 'Judul laporan wajib diisi.',
            'deskripsi.required' => 'Deskripsi masalah wajib diisi.',
            'deskripsi.min' => 'Deskripsi minimal 20 karakter.',
            'tanggal_kejadian.required' => 'Tanggal kejadian wajib diisi.',
            'tanggal_kejadian.before_or_equal' => 'Tanggal kejadian tidak boleh lebih dari hari ini.',
            'attachments.max' => 'Maksimal 5 file lampiran.',
            'attachments.*.max' => 'Ukuran file maksimal 10MB.',
        ]);

        try {
            DB::beginTransaction();

            // Create bug report
            $bugReport = BugReport::create([
                'user_id' => auth()->id(),
                'application_id' => $validated['application_id'],
                'vulnerability_type_id' => $validated['vulnerability_type_id'],
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
                'langkah_reproduksi' => $validated['langkah_reproduksi'] ?? null,
                'dampak' => $validated['dampak'] ?? null,
                'url_terkait' => $validated['url_terkait'] ?? null,
                'tanggal_kejadian' => $validated['tanggal_kejadian'],
                'status' => 'diajukan',
                'status_apresiasi' => 'belum_dinilai',
            ]);

            // Upload attachments
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $this->fileUploadService->uploadAttachment($file, $bugReport, 'screenshot');
                }
            }

            // Create history
            $bugReport->histories()->create([
                'status_lama' => null,
                'status_baru' => 'diajukan',
                'aksi' => 'diajukan',
                'keterangan' => 'Laporan bug baru diajukan',
                'user_id' => auth()->id(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Send notification
            $this->notificationService->notifyBugReportSubmitted($bugReport);

            DB::commit();

            return redirect()->route('user.bug-reports.show', $bugReport)
                ->with('success', 'Laporan bug berhasil diajukan dengan nomor tiket: ' . $bugReport->ticket_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified bug report.
     */
    public function show(BugReport $bugReport)
    {
        // Ensure user can only view their own reports
        if ($bugReport->user_id !== auth()->id()) {
            abort(403);
        }

        $bugReport->load(['application.opd', 'vulnerabilityType', 'attachments', 'histories.user', 'handler']);

        return view('user.bug-reports.show', compact('bugReport'));
    }
}
