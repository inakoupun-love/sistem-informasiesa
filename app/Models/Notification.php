<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'related_model',
        'related_id',
        'data',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns this notification
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if notification is read
     */
    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(): void
    {
        if (!$this->isRead()) {
            $this->update(['read_at' => now()]);
        }
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread(): void
    {
        $this->update(['read_at' => null]);
    }

    /**
     * Get notification icon based on type
     */
    public function getIconAttribute(): string
    {
        return match ($this->type) {
            'pengajuan_disetujui' => 'bi-check-circle',
            'pengajuan_ditolak' => 'bi-x-circle',
            'pengajuan_baru' => 'bi-file-earmark-plus',
            'bansos_disetujui' => 'bi-hand-thumbs-up',
            'bansos_ditolak' => 'bi-hand-thumbs-down',
            'bansos_baru' => 'bi-file-earmark-text',
            'laporan_baru' => 'bi-megaphone',
            'informasi_baru' => 'bi-info-circle',
            'surat_siap_ambil' => 'bi-file-earmark-check',
            'sistem' => 'bi-gear',
            default => 'bi-bell',
        };
    }

    /**
     * Get notification color based on type
     */
    public function getColorAttribute(): string
    {
        return match ($this->type) {
            'pengajuan_disetujui', 'bansos_disetujui', 'surat_siap_ambil' => 'success',
            'pengajuan_ditolak', 'bansos_ditolak' => 'danger',
            'pengajuan_baru', 'bansos_baru', 'laporan_baru' => 'primary',
            'informasi_baru' => 'info',
            'sistem' => 'warning',
            default => 'secondary',
        };
    }

    /**
     * Get URL for notification action (if applicable)
     */
    public function getActionUrlAttribute(): ?string
    {
        return match ($this->type) {
            'pengajuan_disetujui', 'pengajuan_ditolak', 'pengajuan_baru' => route('masyarakat.riwayat'),
            'bansos_disetujui', 'bansos_ditolak', 'bansos_baru' => route('masyarakat.riwayat'),
            'laporan_baru' => route('admin.laporan') ?? null,
            'informasi_baru' => route('masyarakat.informasi') ?? null,
            default => null,
        };
    }
}
