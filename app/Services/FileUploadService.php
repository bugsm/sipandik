<?php

namespace App\Services;

use App\Models\Attachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload single file and create attachment record
     */
    public function uploadAttachment(
        UploadedFile $file,
        $attachable,
        string $tipe = 'dokumen',
        ?string $keterangan = null
    ): Attachment {
        // Generate unique filename
        $extension = $file->getClientOriginalExtension();
        $originalName = $file->getClientOriginalName();
        $filename = Str::uuid() . '.' . $extension;
        
        // Determine folder based on attachable type
        $folder = match(class_basename($attachable)) {
            'BugReport' => 'bug-reports',
            'DataRequest' => 'data-requests',
            default => 'attachments',
        };
        
        // Store file
        $path = $file->storeAs($folder . '/' . $attachable->id, $filename, 'public');
        
        // Create attachment record
        return Attachment::create([
            'attachable_id' => $attachable->id,
            'attachable_type' => get_class($attachable),
            'nama_asli' => $originalName,
            'nama_file' => $filename,
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'ukuran' => $file->getSize(),
            'ekstensi' => $extension,
            'tipe' => $tipe,
            'keterangan' => $keterangan,
            'uploaded_by' => auth()->id(),
        ]);
    }

    /**
     * Upload multiple files
     */
    public function uploadMultipleAttachments(
        array $files,
        $attachable,
        string $tipe = 'dokumen'
    ): array {
        $attachments = [];
        
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $attachments[] = $this->uploadAttachment($file, $attachable, $tipe);
            }
        }
        
        return $attachments;
    }

    /**
     * Delete attachment and its file
     */
    public function deleteAttachment(Attachment $attachment): bool
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($attachment->path)) {
            Storage::disk('public')->delete($attachment->path);
        }
        
        // Delete record
        return $attachment->delete();
    }

    /**
     * Upload data file for data request
     */
    public function uploadDataFile(UploadedFile $file, $dataRequest): array
    {
        $extension = $file->getClientOriginalExtension();
        $originalName = $file->getClientOriginalName();
        $filename = 'data_' . $dataRequest->ticket_number . '_' . now()->format('Ymd_His') . '.' . $extension;
        
        // Store file
        $path = $file->storeAs('data-files/' . $dataRequest->id, $filename, 'public');
        
        return [
            'file_path' => $path,
            'file_name' => $originalName,
            'file_size' => $file->getSize(),
        ];
    }

    /**
     * Get allowed file types for bug reports
     */
    public static function getAllowedBugReportTypes(): array
    {
        return ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt', 'log', 'zip'];
    }

    /**
     * Get allowed file types for data files
     */
    public static function getAllowedDataTypes(): array
    {
        return ['xlsx', 'xls', 'csv', 'pdf', 'json', 'zip'];
    }

    /**
     * Get max file size in bytes (default 10MB)
     */
    public static function getMaxFileSize(): int
    {
        return 10 * 1024 * 1024; // 10MB
    }
}
