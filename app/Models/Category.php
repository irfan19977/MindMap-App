<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Category extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'curriculum',
        'cover_image',
        'parent_id',
        'grade_level',
        'status',
        'order_number',
        'is_featured',
        'is_free',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_free' => 'boolean',
        'order_number' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get the parent category.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get the recursive children.
     */
    public function recursiveChildren()
    {
        return $this->children()->with('recursiveChildren');
    }

    /**
     * Get the materis for this category.
     */
    public function materis()
    {
        return $this->hasMany(Materi::class);
    }

    /**
     * Get all materis from this category and its children.
     */
    public function allMateris()
    {
        $materis = $this->materis;
        
        foreach ($this->children as $child) {
            $materis = $materis->merge($child->allMateris());
        }
        
        return $materis;
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include featured categories.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include free categories.
     */
    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    /**
     * Scope a query to filter by grade level.
     */
    public function scopeGradeLevel($query, $gradeLevel)
    {
        return $query->where('grade_level', $gradeLevel);
    }

    /**
     * Scope a query to get root categories (no parent).
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope a query to order by order number and name.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_number', 'asc')->orderBy('name', 'asc');
    }

    /**
     * Get the formatted grade level.
     */
    public function getFormattedGradeLevelAttribute()
    {
        return match($this->grade_level) {
            'sd' => 'SD',
            'smp' => 'SMP',
            'sma' => 'SMA',
            'umum' => 'Umum',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Get the cover image URL.
     */
    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        
        return asset('backend/assets/images/default-cover.jpg');
    }

    /**
     * Get the full breadcrumb path.
     */
    public function getBreadcrumbAttribute()
    {
        $breadcrumb = [];
        $current = $this;
        
        while ($current) {
            array_unshift($breadcrumb, $current);
            $current = $current->parent;
        }
        
        return $breadcrumb;
    }
}
