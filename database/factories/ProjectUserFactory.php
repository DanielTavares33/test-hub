<?php

namespace Database\Factories;

use App\Enums\ProjectUserRoleEnum;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProjectUserFactory extends Factory
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
            'user_id' => rand(1, User::all()->count()),
            'role' => $this->faker->randomElement(ProjectUserRoleEnum::class),
        ];
    }
}
