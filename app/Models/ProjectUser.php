<?php

namespace App\Models;

use App\Enums\ProjectUserRoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'project_id',
        'user_id',
        'role',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @var \class-string[]
     */
    protected $casts = [
        'role' => ProjectUserRoleEnum::class,
    ];
}
