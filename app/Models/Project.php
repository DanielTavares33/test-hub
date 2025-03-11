<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'status',
    ];

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
