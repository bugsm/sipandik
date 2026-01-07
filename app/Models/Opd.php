<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opd extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'opd';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'kode',
        'nama',
        'singkatan',
        'alamat',
        'telepon',
        'email',
        'website',
        'deskripsi',
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
     * Get applications managed by this OPD
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'opd_id');
    }

    /**
     * Get data requests related to this OPD
     */
    public function dataRequests(): HasMany
    {
        return $this->hasMany(DataRequest::class, 'opd_id');
    }

    /**
     * Scope for active OPD
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get full name with code
     */
    public function getFullNameAttribute(): string
    {
        return "[{$this->kode}] {$this->nama}";
    }
}
