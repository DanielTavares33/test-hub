<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestCaseStep extends Model
{
    protected $fillable = [
      'test_case_id',
      'description',
      'expected_result',
    ];

    /**
     * Belongs to Test Case relationship
     *
     * @return BelongsTo
     */
    public function testCase(): BelongsTo
    {
        return $this->belongsTo(TestCase::class);
    }
}
