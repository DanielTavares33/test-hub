<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\TestCaseTestRunResultEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
