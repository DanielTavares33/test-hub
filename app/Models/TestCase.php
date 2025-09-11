<?php

namespace App\Models;

use App\Enums\TestCasePriorityEnum;
use App\Enums\TestCaseStatusEnum;
use App\Enums\TestCaseTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 *
 * @property int $id
 * @property int $project_id
 * @property int|null $created_by
 * @property string $title
 * @property string $name
 * @property string $description
 * @property TestCaseStatusEnum $status
 * @property TestCasePriorityEnum $priority
 * @property TestCaseTypeEnum $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Bug> $bugs
 * @property-read int|null $bugs_count
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\Project $project
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestCaseStep> $testCaseSteps
 * @property-read int|null $test_case_steps_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestRun> $testRuns
 * @property-read int|null $test_runs_count
 * @method static \Database\Factories\TestCaseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCase query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCase whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCase whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCase wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCase whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCase whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCase whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCase whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCase whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TestCase extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'title',
        'description',
        'status',
        'priority',
        'type',
        'project_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = [
        'status' => TestCaseStatusEnum::class,
        'priority' => TestCasePriorityEnum::class,
        'type' => TestCaseTypeEnum::class,
    ];

    /**
     * Has Many Bugs
     */
    public function bugs(): HasMany
    {
        return $this->hasMany(Bug::class);
    }

    /**
     * Belongs to Many Test Runs
     */
    public function testRuns(): BelongsToMany
    {
        return $this->belongsToMany(TestRun::class, 'test_case_test_run')->withPivot('result', 'comments');
    }

    /**
     * Belongs to User (created_by)
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Belongs to a Project
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Test case steps HasMany relationship
     */
    public function testCaseSteps(): HasMany
    {
        return $this->hasMany(TestCaseStep::class, 'test_case_id');
    }

    /**
     * Belongs to Many Projects (for project_test_cases pivot table)
     */
    public function projectTestCases(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_test_cases');
    }
}
