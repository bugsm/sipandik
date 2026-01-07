<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ReportHistory extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'reportable_id',
        'reportable_type',
        'status_lama',
        'status_baru',
        'aksi',
        'keterangan',
        'user_id',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the parent reportable model (BugReport or DataRequest)
     */
    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who made the change
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get aksi label
     */
    public function getAksiLabelAttribute(): string
    {
        return match($this->aksi) {
            'diajukan' => 'Laporan Diajukan',
            'diverifikasi' => 'Laporan Diverifikasi',
            'diproses' => 'Laporan Sedang Diproses',
            'ditolak' => 'Laporan Ditolak',
            'selesai' => 'Laporan Selesai',
            'tersedia' => 'Data Tersedia',
            'diunduh' => 'Data Diunduh',
            'update_status' => 'Status Diperbarui',
            'update_apresiasi' => 'Status Apresiasi Diperbarui',
            'tambah_catatan' => 'Catatan Ditambahkan',
            default => $this->aksi,
        };
    }

    /**
     * Get aksi color for UI
     */
    public function getAksiColorAttribute(): string
    {
        return match($this->aksi) {
            'diajukan' => 'info',
            'diverifikasi' => 'primary',
            'diproses' => 'warning',
            'ditolak' => 'danger',
            'selesai' => 'success',
            'tersedia' => 'success',
            'diunduh' => 'dark',
            default => 'secondary',
        };
    }

    /**
     * Create history entry for a report
     */
    public static function createEntry(
        Model $report,
        string $aksi,
        ?string $statusLama = null,
        ?string $statusBaru = null,
        ?string $keterangan = null,
        ?User $user = null
    ): self {
        return self::create([
            'reportable_id' => $report->id,
            'reportable_type' => get_class($report),
            'status_lama' => $statusLama,
            'status_baru' => $statusBaru,
            'aksi' => $aksi,
            'keterangan' => $keterangan,
            'user_id' => $user?->id ?? auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
