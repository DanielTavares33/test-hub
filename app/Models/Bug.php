<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property int|null $test_case_id
 * @property int|null $test_run_id
 * @property int|null $reported_by
 * @property int|null $assigned_to
 * @property string $title
 * @property string|null $description
 * @property string $severity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $assignedTo
 * @property-read \App\Models\User|null $reportedBy
 * @property-read \App\Models\TestCase|null $testCase
 * @property-read \App\Models\TestRun|null $testRun
 * @method static \Database\Factories\BugFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bug query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bug whereAssignedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bug whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bug whereReportedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bug whereSeverity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bug whereTestCaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bug whereTestRunId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bug whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bug whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Bug extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'test_case_id',
        'test_run_id',
        'reported_by',
        'assigned_to',
        'title',
        'description',
        'severity',
    ];

    /**
     * Belongs to Test Case
     */
    public function testCase(): BelongsTo
    {
        return $this->belongsTo(TestCase::class);
    }

    /**
     * Belongs To Test Run
     */
    public function testRun(): BelongsTo
    {
        return $this->belongsTo(TestRun::class);
    }

    /**
     * Belongs To User (reported_by)
     */
    public function reportedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    /**
     * Belongs To User (assigned_to)
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
