<?php

namespace App\Services;

use App\Models\BugReport;
use App\Models\DataRequest;
use App\Models\EmailNotification;
use App\Models\User;
use App\Mail\BugReportSubmitted;
use App\Mail\BugReportStatusUpdated;
use App\Mail\DataRequestSubmitted;
use App\Mail\DataRequestStatusUpdated;
use App\Mail\DataAvailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Send notification for new bug report
     */
    public function notifyBugReportSubmitted(BugReport $bugReport)
    {
        try {
            // Notify user
            Mail::to($bugReport->user->email)->send(new BugReportSubmitted($bugReport));
            
            // Notify admins (optional - implemented later)
            // $admins = User::where('role', 'admin')->get();
            // foreach ($admins as $admin) {
            //     Mail::to($admin->email)->send(new BugReportAdminNotification($bugReport));
            // }

            $this->logNotification($bugReport, 'bug_report_submitted', $bugReport->user->email, 'sent');
        } catch (\Exception $e) {
            Log::error('Failed to send bug report submission email: ' . $e->getMessage());
            $this->logNotification($bugReport, 'bug_report_submitted', $bugReport->user->email, 'failed', $e->getMessage());
        }
    }

    /**
     * Send notification for bug report status update
     */
    public function notifyBugReportStatusUpdate(BugReport $bugReport)
    {
        try {
            Mail::to($bugReport->user->email)->send(new BugReportStatusUpdated($bugReport));
            $this->logNotification($bugReport, 'bug_report_status_update', $bugReport->user->email, 'sent');
        } catch (\Exception $e) {
            Log::error('Failed to send bug report status update email: ' . $e->getMessage());
            $this->logNotification($bugReport, 'bug_report_status_update', $bugReport->user->email, 'failed', $e->getMessage());
        }
    }

    /**
     * Send notification for new data request
     */
    public function notifyDataRequestSubmitted(DataRequest $dataRequest)
    {
        try {
            Mail::to($dataRequest->user->email)->send(new DataRequestSubmitted($dataRequest));
            $this->logNotification($dataRequest, 'data_request_submitted', $dataRequest->user->email, 'sent');
        } catch (\Exception $e) {
            Log::error('Failed to send data request submission email: ' . $e->getMessage());
            $this->logNotification($dataRequest, 'data_request_submitted', $dataRequest->user->email, 'failed', $e->getMessage());
        }
    }

    /**
     * Send notification for data request status update
     */
    public function notifyDataRequestStatusUpdate(DataRequest $dataRequest)
    {
        try {
            Mail::to($dataRequest->user->email)->send(new DataRequestStatusUpdated($dataRequest));
            
            // If data is available, also send the DataAvailable email if not sending redundant emails
            if ($dataRequest->status === 'tersedia' && $dataRequest->file_path) {
                Mail::to($dataRequest->user->email)->send(new DataAvailable($dataRequest));
            }
            
            $this->logNotification($dataRequest, 'data_request_status_update', $dataRequest->user->email, 'sent');
        } catch (\Exception $e) {
            Log::error('Failed to send data request status update email: ' . $e->getMessage());
            $this->logNotification($dataRequest, 'data_request_status_update', $dataRequest->user->email, 'failed', $e->getMessage());
        }
    }

    /**
     * Log email notification to database
     */
    private function logNotification($notifiable, string $type, string $recipient, string $status, ?string $error = null)
    {
        EmailNotification::create([
            'notifiable_id' => $notifiable->id,
            'notifiable_type' => get_class($notifiable),
            'user_id' => $notifiable->user_id ?? null,
            'jenis' => $type,
            'email_to' => $recipient,
            'status' => $status,
            'error_message' => $error,
            'sent_at' => $status === 'sent' ? now() : null,
        ]);
    }
}
