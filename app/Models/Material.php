<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Material extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'subcategory_id',
        'title',
        'slug',
        'description',
        'learning_objectives',
        'content',
        'status',
        'is_free',
        'cover_image',
        'latihan_data',
        'quiz_data',
        'created_by',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'latihan_data' => 'array',
        'quiz_data' => 'array',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($material) {
            if (empty($material->slug)) {
                $material->slug = Str::slug($material->title);
            }
        });

        static::updating(function ($material) {
            if ($material->isDirty('title') && empty($material->slug)) {
                $material->slug = Str::slug($material->title);
            }
        });
    }

    /**
     * Get the subcategory that owns the material.
     */
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    /**
     * Get the category through subcategory.
     */
    public function category()
    {
        return $this->subcategory->category ?? null;
    }

    /**
     * Get the mindmaps for the material.
     */
    public function mindmaps(): HasMany
    {
        return $this->hasMany(Mindmap::class);
    }

    /**
     * Get the practice questions for the material.
     */
    public function practiceQuestions(): HasMany
    {
        return $this->hasMany(PracticeQuestion::class);
    }

    /**
     * Get the quizzes for the material.
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Get the user progress for the material.
     */
    public function userProgresses(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Scope a query to only include published materials.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'publish');
    }

    /**
     * Scope a query to only include featured materials.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include free materials.
     */
    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    /**
     * Get the formatted status.
     */
    public function getFormattedStatusAttribute()
    {
        return match($this->status) {
            'publish' => 'Diterbitkan',
            'draft' => 'Draft',
            'inactive' => 'Tidak Aktif',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Get the cover image URL.
     */
    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image ? asset('storage/' . $this->cover_image) : asset('backend/assets/images/default-materi.jpg');
    }
}
