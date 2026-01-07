<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'attachable_id',
        'attachable_type',
        'nama_asli',
        'nama_file',
        'path',
        'mime_type',
        'ukuran',
        'ekstensi',
        'tipe',
        'keterangan',
        'uploaded_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'ukuran' => 'integer',
        ];
    }

    /**
     * Get the parent attachable model (BugReport or DataRequest)
     */
    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who uploaded the attachment
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get full URL of the file
     */
    public function getUrlAttribute(): string
    {
        return Storage::url($this->path);
    }

    /**
     * Get formatted file size
     */
    public function getFormattedSizeAttribute(): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->ukuran;
        $unitIndex = 0;

        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }

        return round($size, 2) . ' ' . $units[$unitIndex];
    }

    /**
     * Get tipe label
     */
    public function getTipeLabelAttribute(): string
    {
        return match($this->tipe) {
            'screenshot' => 'Screenshot',
            'dokumen' => 'Dokumen',
            'log' => 'Log File',
            'video' => 'Video',
            'lainnya' => 'Lainnya',
            default => $this->tipe,
        };
    }

    /**
     * Check if attachment is an image
     */
    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Check if attachment is a video
     */
    public function isVideo(): bool
    {
        return str_starts_with($this->mime_type, 'video/');
    }

    /**
     * Check if attachment is a PDF
     */
    public function isPdf(): bool
    {
        return $this->mime_type === 'application/pdf';
    }

    /**
     * Get icon class based on file type
     */
    public function getIconClassAttribute(): string
    {
        if ($this->isImage()) {
            return 'bi-file-image';
        }
        
        if ($this->isVideo()) {
            return 'bi-file-play';
        }
        
        if ($this->isPdf()) {
            return 'bi-file-pdf';
        }

        return match($this->ekstensi) {
            'doc', 'docx' => 'bi-file-word',
            'xls', 'xlsx' => 'bi-file-excel',
            'ppt', 'pptx' => 'bi-file-ppt',
            'zip', 'rar', '7z' => 'bi-file-zip',
            'txt', 'log' => 'bi-file-text',
            default => 'bi-file-earmark',
        };
    }

    /**
     * Delete file from storage when model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            if ($model->isForceDeleting()) {
                Storage::delete($model->path);
            }
        });
    }
}
