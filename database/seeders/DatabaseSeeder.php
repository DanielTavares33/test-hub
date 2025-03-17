<?php

namespace Database\Seeders;

use App\Models\Bug;
use App\Models\User;
use App\Models\Project;
use App\Models\TestRun;
use App\Models\TestCase;
use App\Models\ProjectUser;
use App\Models\TestCaseStep;
use App\Models\TestCaseTestRun;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
        ]);

        Project::factory(3)->create();

        ProjectUser::factory(3)->create();

        TestCase::factory(20)->create();

        TestCaseStep::factory(40)->create();

        TestRun::factory(10)->create();

        TestCaseTestRun::factory(10)->create();

        Bug::factory(10)->create();
    }
}
