<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MailInquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'is_read',
        'is_trashed',
        'ip_address',
        'user_agent',
        'parent_id',
        'admin_reply',
        'replied_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_trashed' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    protected $hidden = [
        'ip_address',
        'user_agent',
    ];

    protected $appends = [
        'status_badge',
        'short_message',
        'formatted_date',
        'email_domain',
        'is_replied',
    ];

    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('is_read', false);
    }

    public function scopeRead(Builder $query): Builder
    {
        return $query->where('is_read', true);
    }

    public function scopeTrashed(Builder $query): Builder
    {
        return $query->where('is_trashed', true);
    }

    public function scopeNotTrashed(Builder $query): Builder
    {
        return $query->where('is_trashed', false);
    }

    public function scopeReplied(Builder $query): Builder
    {
        return $query->whereNotNull('replied_at');
    }

    public function scopeNotReplied(Builder $query): Builder
    {
        return $query->whereNull('replied_at');
    }

    public function scopeOrderByReadStatus(Builder $query): Builder
    {
        return $query->orderBy('is_read')->latest();
    }

    public function scopeOrderByReplyStatus(Builder $query): Builder
    {
        return $query->orderByRaw('replied_at IS NULL')->latest();
    }

    public function markAsRead(): bool
    {
        if ($this->is_read) {
            return false;
        }

        return $this->update(['is_read' => true]);
    }

    public function markAsUnread(): bool
    {
        if (!$this->is_read) {
            return false;
        }

        return $this->update(['is_read' => false]);
    }

    public function moveToTrash(): bool
    {
        if ($this->is_trashed) {
            return false;
        }

        return $this->update(['is_trashed' => true]);
    }

    public function restoreFromTrash(): bool
    {
        if (!$this->is_trashed) {
            return false;
        }

        return $this->update(['is_trashed' => false]);
    }

    public function reply(string $content): bool
    {
        return $this->update([
            'admin_reply' => $content,
            'replied_at' => now(),
            'is_read' => true
        ]);
    }

    public function getEmailDomainAttribute(): ?string
    {
        $parts = explode('@', $this->email);
        return $parts[1] ?? null;
    }

    public function getIsRepliedAttribute(): bool
    {
        return !is_null($this->replied_at);
    }

    public function getShortMessageAttribute(): string
    {
        return Str::limit($this->message, 100);
    }

    public function getShortReplyAttribute(): ?string
    {
        return $this->admin_reply ? Str::limit($this->admin_reply, 100) : null;
    }

    public function getStatusBadgeAttribute(): string
    {
        if ($this->is_trashed) {
            return '<span class="badge bg-secondary">Trashed</span>';
        }

        if ($this->is_replied) {
            return '<span class="badge bg-success">Replied</span>';
        }

        return $this->is_read
            ? '<span class="badge bg-primary">Read</span>'
            : '<span class="badge bg-warning">Unread</span>';
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('M d, Y');
    }

    public function getFormattedReplyDateAttribute(): ?string
    {
        return $this->replied_at?->format('M d, Y h:i A');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
