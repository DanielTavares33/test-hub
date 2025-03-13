<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TestCaseStep extends Model
{
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
