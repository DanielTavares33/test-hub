<?php

namespace App\Models;

use App\Enums\TestCaseTestRunResultEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $test_case_id
 * @property int $test_run_id
 * @property TestCaseTestRunResultEnum|null $result
 * @property string|null $comments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\TestCaseTestRunFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseTestRun newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseTestRun newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseTestRun query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseTestRun whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseTestRun whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseTestRun whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseTestRun whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseTestRun whereTestCaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseTestRun whereTestRunId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseTestRun whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TestCaseTestRun extends Model
{
    use HasFactory;

    protected $table = 'test_case_test_run';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'test_case_id',
        'test_run_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'result' => TestCaseTestRunResultEnum::class,
    ];
}
