<?php

namespace App\Models;

use App\Enums\TestRunStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
