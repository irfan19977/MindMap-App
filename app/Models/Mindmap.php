<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

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
     * Scope a query to only include published mindmaps.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'publish');
    }
}
