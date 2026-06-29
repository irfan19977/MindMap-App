<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteVisit extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'url',
        'user_agent',
        'visited_date',
    ];

    protected $casts = [
        'visited_date' => 'date',
    ];
}
