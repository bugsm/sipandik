<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class EmailNotification extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'notifiable_id',
        'notifiable_type',
        'jenis',
        'subject',
        'body',
        'email_to',
        'status',
        'sent_at',
        'read_at',
        'error_message',
        'retry_count',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
            'read_at' => 'datetime',
            'retry_count' => 'integer',
        ];
    }

    /**
     * Get the user who receives the notification
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the parent notifiable model (BugReport or DataRequest)
     */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope for pending notifications
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for sent notifications
     */
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope for failed notifications
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Mark notification as sent
     */
    public function markAsSent(): void
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }

    /**
     * Mark notification as failed
     */
    public function markAsFailed(string $errorMessage): void
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
            'retry_count' => $this->retry_count + 1,
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(): void
    {
        $this->update([
            'status' => 'read',
            'read_at' => now(),
        ]);
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pending',
            'sent' => 'Terkirim',
            'failed' => 'Gagal',
            'read' => 'Dibaca',
            default => $this->status,
        };
    }

    /**
     * Get status color for UI
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'sent' => 'success',
            'failed' => 'danger',
            'read' => 'info',
            default => 'secondary',
        };
    }
}
