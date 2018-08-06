<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $employerRole   = Role::whereName('employer')->first();
        $managerRole    = Role::whereName('manager')->first();
        $adminRole      = Role::whereName('admin')->first();

        $employer = User::create(array(
            'name'      => 'Employer',
            'email'     => 'employer@caliacode.com',
            'password'  => Hash::make('password'),
            'status'    => true
        ));
        $employer->assignRole($employerRole);

        $manager = User::create(array(
            'name'      => 'Manager',
            'email'     => 'manager@caliacode.com',
            'password'  => Hash::make('password'),
            'status'    => true
        ));
        $manager->assignRole($managerRole);

        $manager = User::create(array(
            'name'      => 'Admin',
            'email'     => 'admin@caliacode.com',
            'password'  => Hash::make('password'),
            'status'    => true
        ));
        $manager->assignRole($adminRole);
    }
}
