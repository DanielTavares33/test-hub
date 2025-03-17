<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
     *
     * @return BelongsTo
     */
    public function testCase(): BelongsTo
    {
        return $this->belongsTo(TestCase::class);
    }

    /**
     * Belongs To Test Run
     *
     * @return BelongsTo
     */
    public function testRun(): BelongsTo
    {
        return $this->belongsTo(TestRun::class);
    }

    /**
     * Belongs To User (reported_by)
     *
     * @return BelongsTo
     */
    public function reportedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
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
}
