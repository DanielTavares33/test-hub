<?php

namespace Database\Factories;

use App\Enums\TestRunStatusEnum;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestRun>
 */
class TestRunFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => rand(1, Project::all()->count()),
            'assigned_to' => rand(1, User::all()->count()),
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'start_time' => $this->faker->dateTime,
            'end_time' => $this->faker->dateTime,
            'status' => $this->faker->randomElement(TestRunStatusEnum::class),
        ];
    }
}
