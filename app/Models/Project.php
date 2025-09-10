<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestCase> $projectTestCases
 * @property-read int|null $project_test_cases_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestRun> $projectTestRuns
 * @property-read int|null $project_test_runs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestCase> $testCases
 * @property-read int|null $test_cases_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestRun> $testRuns
 * @property-read int|null $test_runs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\ProjectFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'user_id',
        'status',
    ];

    /**
     * Belongs to Many Users
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_users');
    }

    /**
     * Has Many Test Cases
     */
    public function testCases(): HasMany
    {
        return $this->hasMany(TestCase::class);
    }

    /**
     * Has Many Test Runs
     */
    public function testRuns(): HasMany
    {
        return $this->hasMany(TestRun::class);
    }

    /**
     * Belongs to Many Test Cases
     */
    public function projectTestCases()
    {
        return $this->belongsToMany(TestCase::class, 'project_test_cases');
    }

    /**
     * Belongs to Many Test Runs
     */
    public function projectTestRuns()
    {
        return $this->belongsToMany(TestRun::class, 'project_test_runs');
    }
}
