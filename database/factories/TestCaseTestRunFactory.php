<?php

namespace Database\Factories;

use App\Models\TestRun;
use App\Models\TestCase;
use App\Enums\TestCaseTestRunResultEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TestCaseTestRunFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'test_case_id' => rand(1, TestCase::all()->count()),
            'test_run_id' => rand(1, TestRun::all()->count()),
            'result' => $this->faker->randomElement(TestCaseTestRunResultEnum::class),
            'comments' => $this->faker->text
        ];
    }
}
