<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestRun extends Model
{
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
     * Belongs To Project
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Belongs To User (assigned_to)
     *
     * @return BelongsTo
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Belongs To Many Test Cases
     *
     * @return BelongsToMany
     */
    public function testCases(): BelongsToMany
    {
        return $this->belongsToMany(TestCase::class, 'test_case_test_run')->withPivot('result', 'comments');
    }
}
