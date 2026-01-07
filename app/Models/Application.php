<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'opd_id',
        'nama',
        'versi',
        'url',
        'deskripsi',
        'platform',
        'pic_nama',
        'pic_telepon',
        'pic_email',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the OPD that manages this application
     */
    public function opd(): BelongsTo
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }

    /**
     * Get bug reports for this application
     */
    public function bugReports(): HasMany
    {
        return $this->hasMany(BugReport::class, 'application_id');
    }

    /**
     * Scope for active applications
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get application name with OPD
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->nama} - {$this->opd->singkatan}";
    }

    /**
     * Get platform label
     */
    public function getPlatformLabelAttribute(): string
    {
        return match($this->platform) {
            'web' => 'Web Application',
            'mobile' => 'Mobile Application',
            'desktop' => 'Desktop Application',
            'api' => 'API Service',
            'lainnya' => 'Lainnya',
            default => $this->platform,
        };
    }
}
