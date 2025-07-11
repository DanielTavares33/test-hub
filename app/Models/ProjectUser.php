<?php

namespace App\Models;

use App\Enums\ProjectUserRoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $project_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property ProjectUserRoleEnum $role
 * @method static \Database\Factories\ProjectUserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectUser whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectUser whereUserId($value)
 * @mixin \Eloquent
 */
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
