<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\ProjectFeature;
use App\Models\ProjectTechnology;
use App\Models\Skill;
use App\Models\Social;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create specific users
        $michael = User::factory()->create([
            'name' => 'Fabian Ternis',
            'username' => 'michaelninder',
            'email' => 'f.ternis@xpsystems.eu',
            'password' => Hash::make('Password'),
        ]);

        $dogwater = User::factory()->create([
            'name' => 'Ramsay Brewer',
            'username' => 'DogWaterDev',
            'email' => 'r.brewer@xpsystems.eu',
            'password' => Hash::make('Password'),
        ]);

        // Create 1 to 18 additional random users
        $numberOfAdditionalUsers = rand(1, 18);
        $additionalUsers = User::factory($numberOfAdditionalUsers)->create([
            'password' => Hash::make('Password'),
        ]);

        $users = collect([$michael, $dogwater])->merge($additionalUsers);

        foreach ($users as $user) {
            // Create Education records
            Education::factory(rand(1, 3))->for($user)->create();

            // Create Experience records
            Experience::factory(rand(1, 4))->for($user)->create();

            // Create Project records
            Project::factory(rand(2, 5))->for($user)->create()->each(function (Project $project) {
                // Create Project Features for each project
                ProjectFeature::factory(rand(1, 3))->for($project)->create();
                // Create Project Technologies for each project
                ProjectTechnology::factory(rand(1, 5))->for($project)->create();
            });

            // Create Skill records
            Skill::factory(rand(3, 7))->for($user)->create();
        }
    }
}