<?php

namespace Database\Factories;

use App\Models\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestCaseStep>
 */
class TestCaseStepFactory extends Factory
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
            'description' => $this->faker->paragraph(),
            'expected_result' => $this->faker->paragraph(),
        ];
    }
}
