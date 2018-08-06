<?php

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->delete();

        // Retrive users
        $employer   = User::where('name', 'Employer')->first();
        $manager    = User::where('name', 'Employer')->first();
        $admin      = User::where('name', 'Admin')->first();

        // Retrieve clients
        $janeDoe = Client::where('company', 'Jane Doe Company')->first();
        $johnDoe = Client::where('company', 'John Doe Company')->first();

        // Create Projects
        $janeDoePhotography  = ['name' => 'Jane Doe Photography', 'description' => 'A personal Jane Doe Blog about photography.'];
        $project = $manager->projects()->create($janeDoePhotography);
        $project->client()->associate($janeDoe)->save();

        // Assign project to Employer
        $employer->assignedProjects()->attach($project->id);

        $janeDoeGift  = ['name' => 'Jane Doe Gifts', 'description' => 'A Jane Doe Online e-commerce Gift Shop.'];
        $project = $admin->projects()->create($janeDoeGift);
        $project->client()->associate($janeDoe)->save();

        $johnDoeSocial = ['name' => 'John Doe Social', 'description' => 'John Doe meeting social network.'];
        $project = $manager->projects()->create($johnDoeSocial);
        $project->client()->associate($johnDoe)->save();

        // Assign project to Employer
        $employer->assignedProjects()->attach($project->id);

        $johnDoeIdeas = ['name' => 'John Doe Forum', 'description' => 'Forum idea sharing platform for developers.'];
        $project = $admin->projects()->create($johnDoeIdeas);
        $project->client()->associate($johnDoe)->save();

        

    }
}
