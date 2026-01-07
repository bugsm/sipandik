<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\BugReportsExport;
use App\Models\BugReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BugReportController extends Controller
{
    /**
     * Display a listing of bug reports.
     */
    public function index(Request $request)
    {
        $query = BugReport::with(['user', 'application.opd', 'vulnerabilityType', 'handler'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by apresiasi
        if ($request->filled('apresiasi')) {
            $query->where('status_apresiasi', $request->apresiasi);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('judul', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $bugReports = $query->paginate(15);

        return view('admin.bug-reports.index', compact('bugReports'));
    }

    /**
     * Display the specified bug report.
     */
    public function show(BugReport $bugReport)
    {
        $bugReport->load(['user', 'application.opd', 'vulnerabilityType', 'attachments', 'histories.user', 'handler']);
        
        return view('admin.bug-reports.show', compact('bugReport'));
    }

    /**
     * Update the status of bug report.
     */
    public function updateStatus(Request $request, BugReport $bugReport)
    {
        $validated = $request->validate([
            'status' => 'required|in:diajukan,diverifikasi,diproses,selesai,ditolak',
            'catatan' => 'nullable|string|max:500',
        ]);

        $oldStatus = $bugReport->status;
        
        $bugReport->update([
            'status' => $validated['status'],
            'catatan_admin' => $validated['catatan'] ?? $bugReport->catatan_admin,
            'handled_by' => auth()->id(),
            'handled_at' => now(),
        ]);

        // Create history
        $bugReport->histories()->create([
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
        $notificationService->notifyBugReportStatusUpdate($bugReport);

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    /**
     * Update the apresiasi status of bug report.
     */
    public function updateApresiasi(Request $request, BugReport $bugReport)
    {
        $validated = $request->validate([
            'status_apresiasi' => 'required|in:belum_dinilai,ditolak,diapresiasi,hall_of_fame',
        ]);

        $oldApresiasi = $bugReport->status_apresiasi;
        
        $bugReport->update([
            'status_apresiasi' => $validated['status_apresiasi'],
        ]);

        // Create history
        $bugReport->histories()->create([
            'status_lama' => $oldApresiasi,
            'status_baru' => $validated['status_apresiasi'],
            'aksi' => 'update_apresiasi',
            'keterangan' => 'Status apresiasi diubah menjadi ' . $validated['status_apresiasi'],
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Status apresiasi berhasil diperbarui.');
    }

    /**
     * Toggle folder check status.
     */
    public function toggleFolder(Request $request, BugReport $bugReport)
    {
        $validated = $request->validate([
            'folder_checked' => 'required|boolean',
            'folder_path' => 'nullable|string|max:255',
        ]);

        $bugReport->update([
            'folder_checked' => $validated['folder_checked'],
            'folder_path' => $validated['folder_path'] ?? $bugReport->folder_path,
        ]);

        // Create history
        $bugReport->histories()->create([
            'status_lama' => $bugReport->folder_checked ? 'checked' : 'unchecked',
            'status_baru' => $validated['folder_checked'] ? 'checked' : 'unchecked',
            'aksi' => 'update_folder',
            'keterangan' => $validated['folder_checked'] ? 'Folder sudah dicek' : 'Folder belum dicek',
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Status folder berhasil diperbarui.');
    }

    /**
     * Add admin note.
     */
    public function addNote(Request $request, BugReport $bugReport)
    {
        $validated = $request->validate([
            'catatan_admin' => 'required|string|max:1000',
        ]);

        $bugReport->update([
            'catatan_admin' => $validated['catatan_admin'],
        ]);

        return back()->with('success', 'Catatan admin berhasil disimpan.');
    }

    /**
     * Export bug reports.
     */
    public function export($format)
    {
        if (!in_array($format, ['xlsx', 'pdf'])) {
            abort(404);
        }

        $date = now()->format('d-m-Y');

        if ($format === 'xlsx') {
            return Excel::download(new BugReportsExport, 'laporan-bug-reports-' . $date . '.xlsx');
        }

        if ($format === 'pdf') {
            $bugReports = BugReport::with(['user', 'application.opd', 'vulnerabilityType'])
                ->latest()
                ->get();

            $pdf = Pdf::loadView('exports.bug-reports-pdf', [
                'bugReports' => $bugReports,
                'date' => now()->translatedFormat('d F Y')
            ]);
            
            $pdf->setPaper('a4', 'landscape');

            return $pdf->download('laporan-bug-reports-' . $date . '.pdf');
        }
    }
}
