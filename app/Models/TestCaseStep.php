<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * 
 *
 * @property int $id
 * @property int $test_case_id
 * @property string|null $description
 * @property string|null $expected_result
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestCase> $testCase
 * @property-read int|null $test_case_count
 * @method static \Database\Factories\TestCaseStepFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseStep newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseStep newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseStep query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseStep whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseStep whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseStep whereExpectedResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseStep whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseStep whereTestCaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestCaseStep whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TestCaseStep extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'test_case_id',
        'description',
        'expected_result',
    ];

    /**
     * Belongs to Test Case
     *
     * @return BelongsTo
     */
    public function testCase(): BelongsToMany
    {
        return $this->belongsToMany(TestCase::class, 'test_cases')->withPivot('description', 'expected_result');
    }
}
