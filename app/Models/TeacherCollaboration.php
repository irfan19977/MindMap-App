<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherCollaboration extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'admin_id',
        'teacher_id',
        'category_id',
        'subcategory_id',
        'class_id',
        'collaboration_type',
        'message',
        'status',
        'permissions',
        'invited_at',
        'responded_at',
    ];

    protected $casts = [
        'permissions' => 'array',
        'invited_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    /**
     * Get the admin who sent the invitation.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get the teacher who was invited.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the category for collaboration.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the subcategory for collaboration.
     */
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    /**
     * Get the class for collaboration.
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(CourseClass::class, 'class_id');
    }

    /**
     * Scope a query to only include pending collaborations.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include accepted collaborations.
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope a query to only include rejected collaborations.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Get the formatted status attribute.
     */
    public function getFormattedStatusAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Respon',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            'revoked' => 'Dibatalkan',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Get the collaboration target name.
     */
    public function getTargetNameAttribute(): string
    {
        return match ($this->collaboration_type) {
            'category' => $this->category?->name ?? 'Kategori Tidak Diketahui',
            'subcategory' => $this->subcategory?->name ?? 'Sub Kategori Tidak Diketahui',
            'class' => $this->class?->name ?? 'Kelas Tidak Diketahui',
            default => 'Target Tidak Diketahui',
        };
    }

    /**
     * Check if teacher has permission for specific action.
     */
    public function hasPermission(string $permission): bool
    {
        if (!$this->permissions || $this->status !== 'accepted') {
            return false;
        }

        return in_array($permission, $this->permissions);
    }

    /**
     * Accept the collaboration.
     */
    public function accept(): void
    {
        $this->update([
            'status' => 'accepted',
            'responded_at' => now(),
        ]);
    }

    /**
     * Reject the collaboration.
     */
    public function reject(): void
    {
        $this->update([
            'status' => 'rejected',
            'responded_at' => now(),
        ]);
    }

    /**
     * Revoke the collaboration.
     */
    public function revoke(): void
    {
        $this->update([
            'status' => 'revoked',
            'responded_at' => now(),
        ]);
    }
}
