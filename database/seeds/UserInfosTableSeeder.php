<?php

use Illuminate\Database\Seeder;
use App\Models\UserInfo;
use App\Models\User;

class UserInfosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_infos')->delete();

        // Retrive users
        $employer   = User::where('name', 'Employer')->first();
        $manager    = User::where('name', 'Manager')->first();
        $admin      = User::where('name', 'Admin')->first();

        // Create User Info
        $employer->userInfo()->create(['first_name' => 'Amber', 'last_name' => 'Doe']);
        $manager->userInfo()->create(['first_name' => 'James', 'last_name' => 'Doe']);
        $admin->userInfo()->create(['first_name' => 'Chris', 'last_name' => 'Doe']);
    }
}
