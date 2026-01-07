<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasUuids, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'nip',
        'jabatan',
        'role',
        'password',
        'avatar',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Get bug reports submitted by this user
     */
    public function bugReports(): HasMany
    {
        return $this->hasMany(BugReport::class, 'user_id');
    }

    /**
     * Get bug reports handled by this admin
     */
    public function handledBugReports(): HasMany
    {
        return $this->hasMany(BugReport::class, 'handled_by');
    }

    /**
     * Get data requests submitted by this user
     */
    public function dataRequests(): HasMany
    {
        return $this->hasMany(DataRequest::class, 'user_id');
    }

    /**
     * Get data requests handled by this admin
     */
    public function handledDataRequests(): HasMany
    {
        return $this->hasMany(DataRequest::class, 'handled_by');
    }

    /**
     * Get attachments uploaded by this user
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class, 'uploaded_by');
    }

    /**
     * Get report histories by this user
     */
    public function reportHistories(): HasMany
    {
        return $this->hasMany(ReportHistory::class, 'user_id');
    }

    /**
     * Get email notifications for this user
     */
    public function emailNotifications(): HasMany
    {
        return $this->hasMany(EmailNotification::class, 'user_id');
    }
}
