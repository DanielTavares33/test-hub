<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestCase extends Model
{
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
        'type'
    ];

    /**
     * Has Many Bugs
     *
     * @return HasMany
     */
    public function bugs(): HasMany
    {
        return $this->hasMany(Bug::class);
    }

    /**
     * Belongs to Many Test Runs
     *
     * @return BelongsToMany
     */
    public function testRuns(): BelongsToMany
    {
        return $this->belongsToMany(TestRun::class, 'test_case_test_run')->withPivot('result', 'comments');
    }

    /**
     * Belongs to User (created_by)
     *
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Belongs to a Project
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Test case steps HasMany relationship
     *
     * @return HasMany
     */
    public function testCaseSteps(): HasMany
    {
        return $this->hasMany(TestCaseStep::class);
    }
}
