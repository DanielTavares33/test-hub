<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestCase extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'type'
    ];

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
