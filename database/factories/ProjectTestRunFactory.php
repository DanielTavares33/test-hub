<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\TestRun;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProjectTestRunFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => rand(1, Project::count()),
            'test_run_id' => rand(1, TestRun::count()),
        ];
    }
}
