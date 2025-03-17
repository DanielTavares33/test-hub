<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\TestRun;
use App\Models\TestCase;
use App\Enums\BugSeverityEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bug>
 */
class BugFactory extends Factory
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
            'reported_by' => rand(1, User::all()->count()),
            'assigned_to' => rand(1, User::all()->count()),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'severity' => $this->faker->randomElement(BugSeverityEnum::class),
        ];
    }
}
