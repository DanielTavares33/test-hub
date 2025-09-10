<?php

namespace Database\Seeders;

use App\Models\Bug;
use App\Models\Project;
use App\Models\ProjectTestCase;
use App\Models\ProjectTestRun;
use App\Models\ProjectUser;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\TestCase;
use App\Models\TestCaseStep;
use App\Models\TestCaseTestRun;
use App\Models\TestRun;
use App\Models\User;
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

        Project::factory(5)->create();

        ProjectUser::factory(5)->create();

        TestCase::factory(20)->create();

        TestCaseStep::factory(40)->create();

        TestRun::factory(10)->create();

        TestCaseTestRun::factory(10)->create();

        Bug::factory(10)->create();

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'tester']);
        Role::create(['name' => 'developer']);
        Role::create(['name' => 'guest']);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'role_id' => 1,
        ]);

        ProjectTestCase::factory(40)->create();
        ProjectTestRun::factory(10)->create();
    }
}
