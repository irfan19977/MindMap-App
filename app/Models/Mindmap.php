<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mindmap extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'material_id',
        'title',
        'structure',
        'thumbnail',
        'status',
    ];

    protected $casts = [
        'structure' => 'array',
    ];

    /**
     * Get the material that owns the mindmap.
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Scope a query to only include published mindmaps.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'publish');
    }
}
