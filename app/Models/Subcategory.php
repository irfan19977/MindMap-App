<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subcategory extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'grade_level',
        'curriculum',
        'status',
        'cover_image',
        'is_featured',
        'created_by',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    /**
     * Get the category that owns the subcategory.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the materials for the subcategory.
     */
    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    /**
     * Scope a query to only include active subcategories.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'publish');
    }

    /**
     * Scope a query to only include featured subcategories.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include subcategories of a specific grade level.
     */
    public function scopeGradeLevel($query, $level)
    {
        return $query->where('grade_level', $level);
    }

    /**
     * Scope a query to order by name.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('name', 'asc');
    }

    /**
     * Get formatted grade level.
     */
    public function getFormattedGradeLevelAttribute(): string
    {
        return match($this->grade_level) {
            'sd' => 'SD',
            'smp' => 'SMP',
            'sma' => 'SMA',
            'umum' => 'Umum',
            default => 'Unknown',
        };
    }

    /**
     * Get the cover image URL.
     */
    public function getCoverImageUrlAttribute(): string
    {
        return $this->cover_image ? asset('storage/' . $this->cover_image) : asset('backend/assets/images/default-cover.png');
    }
}
