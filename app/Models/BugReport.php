<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BugReport extends Model
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
        'application_id',
        'vulnerability_type_id',
        'judul',
        'deskripsi',
        'langkah_reproduksi',
        'dampak',
        'url_terkait',
        'tanggal_kejadian',
        'status',
        'status_apresiasi',
        'folder_checked',
        'folder_path',
        'handled_by',
        'handled_at',
        'catatan_admin',
        'solusi',
        'prioritas',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_kejadian' => 'date',
            'handled_at' => 'datetime',
            'folder_checked' => 'boolean',
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
        $prefix = 'BUG';
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(4));
        
        return "{$prefix}-{$date}-{$random}";
    }

    /**
     * Get the user who submitted the report
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the application being reported
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    /**
     * Get the vulnerability type
     */
    public function vulnerabilityType(): BelongsTo
    {
        return $this->belongsTo(VulnerabilityType::class, 'vulnerability_type_id');
    }

    /**
     * Get the admin who handled the report
     */
    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    /**
     * Get attachments for this report
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    /**
     * Get history for this report
     */
    public function histories(): MorphMany
    {
        return $this->morphMany(ReportHistory::class, 'reportable');
    }

    /**
     * Get email notifications for this report
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
     * Scope for filtering by status apresiasi
     */
    public function scopeStatusApresiasi($query, string $status)
    {
        return $query->where('status_apresiasi', $status);
    }

    /**
     * Scope for pending reports
     */
    public function scopePending($query)
    {
        return $query->where('status', 'diajukan');
    }

    /**
     * Scope for reports in progress
     */
    public function scopeInProgress($query)
    {
        return $query->whereIn('status', ['diverifikasi', 'diproses']);
    }

    /**
     * Scope for completed reports
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'selesai');
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
            'ditolak' => 'danger',
            'selesai' => 'success',
            default => 'secondary',
        };
    }

    /**
     * Get status apresiasi label
     */
    public function getStatusApresiasiLabelAttribute(): string
    {
        return match($this->status_apresiasi) {
            'belum_dinilai' => 'Belum Dinilai',
            'ditolak' => 'Ditolak',
            'diapresiasi' => 'Diapresiasi',
            'hall_of_fame' => 'Hall of Fame',
            default => $this->status_apresiasi,
        };
    }

    /**
     * Get status apresiasi color for UI
     */
    public function getStatusApresiasiColorAttribute(): string
    {
        return match($this->status_apresiasi) {
            'belum_dinilai' => 'secondary',
            'ditolak' => 'danger',
            'diapresiasi' => 'success',
            'hall_of_fame' => 'warning',
            default => 'secondary',
        };
    }

    /**
     * Get prioritas label
     */
    public function getPrioritasLabelAttribute(): string
    {
        return match($this->prioritas) {
            'rendah' => 'Rendah',
            'sedang' => 'Sedang',
            'tinggi' => 'Tinggi',
            'urgent' => 'Urgent',
            default => $this->prioritas,
        };
    }

    /**
     * Get prioritas color for UI
     */
    public function getPrioritasColorAttribute(): string
    {
        return match($this->prioritas) {
            'rendah' => 'success',
            'sedang' => 'info',
            'tinggi' => 'warning',
            'urgent' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get OPD pengelola (through application)
     */
    public function getOpdPengelolaAttribute()
    {
        return $this->application?->opd;
    }
}
