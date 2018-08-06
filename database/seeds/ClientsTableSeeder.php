<?php

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->delete();

        // Retrive users
        $manager = User::where('name', 'Manager')->first();
        $admin = User::where('name', 'Admin')->first();

        // Create clients
        $firstClient = [];
        $firstClient['company']     = 'John Doe Company';
        $firstClient['email']       = 'info@john-doe.com';
        $firstClient['phone']       = '+39 123456789';
        $firstClient['mobile']      = '+39 123456789';
        $firstClient['website']     = 'http://www.john-doe.com';
        $firstClient['vat_number']  = '6589';
        $firstClient['country']     = 'US';
        $firstClient['province']    = 'California';
        $firstClient['address']     = 'Some street';
        $firstClient['zip_code']    = '5981648';

        $manager->clients()->create($firstClient);


        $secondClient = [];
        $secondClient['company']     = 'Jane Doe Company';
        $secondClient['email']       = 'info0@jane-doe.com';
        $secondClient['phone']       = '+39 123456789';
        $secondClient['mobile']      = '+39 123456789';
        $secondClient['website']     = 'http://www.jane-doe.com';
        $secondClient['vat_number']  = '6589';
        $secondClient['country']     = 'UK';
        $secondClient['province']    = 'York';
        $secondClient['address']     = 'Some street';
        $secondClient['zip_code']    = '5981648';

        $admin->clients()->create($secondClient);

    }
}
