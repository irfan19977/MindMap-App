<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class UmumUser extends Model
{
    use HasUuids;

    protected $table = 'umum_users';

    protected $fillable = [
        'user_id',
        'phone',
        'occupation',
        'learning_interest',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getNameAttribute()
    {
        return $this->user->name ?? '';
    }

    public function getEmailAttribute()
    {
        return $this->user->email ?? '';
    }
}
