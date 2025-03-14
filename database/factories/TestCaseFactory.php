<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use App\TestCasePriorityEnum;
use App\TestCaseStatusEnum;
use App\TestCaseTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestCase>
 */
class TestCaseFactory extends Factory
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
            'created_by' => rand(1, User::all()->count()),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(TestCaseStatusEnum::class),
            'priority' => $this->faker->randomElement(TestCasePriorityEnum::class),
            'type' => $this->faker->randomElement(TestCaseTypeEnum::class),
        ];
    }
}
