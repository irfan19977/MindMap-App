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
        'reference_id',
        'title',
        'structure',
        'thumbnail',
        'status',
        'created_by',
    ];

    protected $casts = [
        'structure' => 'array',
    ];

    /**
     * Get the user who created the mindmap.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the category referenced by this mindmap (if reference_id is a category).
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'reference_id');
    }

    /**
     * Get the subcategory referenced by this mindmap (if reference_id is a subcategory).
     */
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class, 'reference_id');
    }

    /**
     * Scope a query to only include published mindmaps.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'publish');
    }
}
