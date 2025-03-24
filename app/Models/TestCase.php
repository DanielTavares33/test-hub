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

class TestCase extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'type',
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
}
