<?php

use App\Models\Category;
use App\Models\Project;
use Illuminate\Database\Seeder;

class AccountGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account_groups')->delete();

        $ftp        = Category::where('name', 'Ftp')->first();
        $login      = Category::where('name', 'Login')->first();
        $social     = Category::where('name', 'Social')->first();
        $website    = Category::where('name', 'Website')->first();

        // Jane Doe Photography
        $project = Project::where('name', 'Jane Doe Photography')->first();
        $project->accountGroups()
            ->create(['title' => 'Facebook'])
            ->category()
            ->associate($social)
            ->save();

        $project->accountGroups()
            ->create(['title' => 'Google+'])
            ->category()
            ->associate($social)
            ->save();

        $project->accountGroups()
            ->create(['title' => 'My Website'])
            ->category()
            ->associate($website)
            ->save();

        $project->accountGroups()
            ->create(['title' => 'Ftp'])
            ->category()
            ->associate($ftp)
            ->save();

        // Jane Doe Gifts
        $project = Project::where('name', 'Jane Doe Gifts')->first();   

        $project->accountGroups()
            ->create(['title' => 'Shop'])
            ->category()
            ->associate($website)
            ->save();

        $project->accountGroups()
            ->create(['title' => 'Subscription'])
            ->category()
            ->associate($login)
            ->save();

        // John Doe Social
        $project = Project::where('name', 'John Doe Social')->first();
        $project->accountGroups()
            ->create(['title' => 'Pinterest'])
            ->category()
            ->associate($social)
            ->save();

        $project->accountGroups()
            ->create(['title' => 'Account'])
            ->category()
            ->associate($login)
            ->save();

        // John Doe Forum
        $project = Project::where('name', 'John Doe Forum')->first();
        $project->accountGroups()
            ->create(['title' => 'Twitter'])
            ->category()
            ->associate($social)
            ->save();

        $project->accountGroups()
            ->create(['title' => 'The Forum'])
            ->category()
            ->associate($ftp)
            ->save();
    }
}
