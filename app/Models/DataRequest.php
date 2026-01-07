<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DataRequest extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'ticket_number',
        'user_id',
        'opd_id',
        'nama_data',
        'sumber_data',
        'tahun_periode',
        'tujuan_penggunaan',
        'deskripsi',
        'format_data',
        'status',
        'handled_by',
        'handled_at',
        'catatan_admin',
        'alasan_penolakan',
        'file_path',
        'file_name',
        'file_size',
        'downloaded_at',
        'download_count',
        'tanggal_dibutuhkan',
        'expired_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'format_data' => 'array',
            'handled_at' => 'datetime',
            'downloaded_at' => 'datetime',
            'tanggal_dibutuhkan' => 'date',
            'expired_at' => 'datetime',
            'download_count' => 'integer',
            'file_size' => 'integer',
        ];
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->ticket_number)) {
                $model->ticket_number = self::generateTicketNumber();
            }
        });
    }

    /**
     * Generate unique ticket number
     */
    public static function generateTicketNumber(): string
    {
        $prefix = 'DATA';
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(4));
        
        return "{$prefix}-{$date}-{$random}";
    }

    /**
     * Get the user who submitted the request
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the OPD source
     */
    public function opd(): BelongsTo
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }

    /**
     * Get the admin who handled the request
     */
    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    /**
     * Get attachments for this request
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    /**
     * Get history for this request
     */
    public function histories(): MorphMany
    {
        return $this->morphMany(ReportHistory::class, 'reportable');
    }

    /**
     * Get email notifications for this request
     */
    public function emailNotifications(): MorphMany
    {
        return $this->morphMany(EmailNotification::class, 'notifiable');
    }

    /**
     * Scope for filtering by status
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for pending requests
     */
    public function scopePending($query)
    {
        return $query->where('status', 'diajukan');
    }

    /**
     * Scope for available data
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'tersedia');
    }

    /**
     * Scope for completed requests
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'selesai');
    }

    /**
     * Check if download link is expired
     */
    public function isExpired(): bool
    {
        if ($this->expired_at === null) {
            return false;
        }
        
        return $this->expired_at->isPast();
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'diajukan' => 'Diajukan',
            'diverifikasi' => 'Diverifikasi',
            'diproses' => 'Diproses',
            'tersedia' => 'Tersedia',
            'ditolak' => 'Ditolak',
            'selesai' => 'Selesai',
            default => $this->status,
        };
    }

    /**
     * Get status color for UI
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'diajukan' => 'info',
            'diverifikasi' => 'primary',
            'diproses' => 'warning',
            'tersedia' => 'success',
            'ditolak' => 'danger',
            'selesai' => 'dark',
            default => 'secondary',
        };
    }

    /**
     * Get formatted file size
     */
    public function getFormattedFileSizeAttribute(): string
    {
        if ($this->file_size === null) {
            return '-';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unitIndex = 0;

        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }

        return round($size, 2) . ' ' . $units[$unitIndex];
    }

    /**
     * Get format data as string
     */
    public function getFormatDataStringAttribute(): string
    {
        if (empty($this->format_data)) {
            return '-';
        }

        return implode(', ', array_map('strtoupper', $this->format_data));
    }

    /**
     * Increment download count
     */
    public function incrementDownloadCount(): void
    {
        $this->increment('download_count');
        $this->update(['downloaded_at' => now()]);
    }
    /**
     * Alias for getFormattedFileSizeAttribute
     */
    public function getFileSizeFormatted()
    {
        return $this->getFormattedFileSizeAttribute();
    }
}
