<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProgress extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'material_id',
        'progress_percentage',
        'completed_at',
    ];

    protected $casts = [
        'progress_percentage' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the progress.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the material that owns the progress.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
