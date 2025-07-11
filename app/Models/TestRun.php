<?php

namespace App\Models;

use App\Enums\TestRunStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * 
 *
 * @property int $id
 * @property int $project_id
 * @property int|null $assigned_to
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $start_time
 * @property \Illuminate\Support\Carbon|null $end_time
 * @property TestRunStatusEnum $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $assignedTo
 * @property-read \App\Models\Project $project
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestCase> $testCases
 * @property-read int|null $test_cases_count
 * @method static \Database\Factories\TestRunFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestRun newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestRun newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestRun query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestRun whereAssignedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestRun whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestRun whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestRun whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestRun whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestRun whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestRun whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestRun whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestRun whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestRun whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TestRun extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'project_id',
        'assigned_to',
        'name',
        'description',
        'start_time',
        'end_time',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'status' => TestRunStatusEnum::class,
    ];

    /**
     * Belongs To Project
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Belongs To User (assigned_to)
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Belongs To Many Test Cases
     */
    public function testCases(): BelongsToMany
    {
        return $this->belongsToMany(TestCase::class, 'test_case_test_run')->withPivot('result', 'comments');
    }
}
