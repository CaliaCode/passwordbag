<?php

use App\Models\Account;
use App\Models\AccountGroup;
use Illuminate\Database\Seeder;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->delete();

        // Jane Doe Photography
        //-------------------------------------
        $accountGroup = AccountGroup::where('title', 'Facebook')->first();
        $accountGroup->accounts()->saveMany([
            new Account(['name' => 'Email', 'value' => 'info@jane-doe.com', 'value_type' => 'email', 'position' => 0]),
            new Account(['name' => 'Password', 'value' => encrypt('secret'), 'value_type' => 'password', 'position' => 1]),
            new Account(['name' => 'Link', 'value' => 'http://www.facebook.com/login', 'value_type' => 'link', 'position' => 2])
        ]);

        $accountGroup = AccountGroup::where('title', 'Google+')->first();
        $accountGroup->accounts()->saveMany([
            new Account(['name' => 'Email', 'value' => 'info@jane-doe.com', 'value_type' => 'email', 'position' => 0]),
            new Account(['name' => 'Password', 'value' => encrypt('secret'), 'value_type' => 'password', 'position' => 1]),
            new Account(['name' => 'Link', 'value' => 'https://accounts.google.com/login', 'value_type' => 'link', 'position' => 2])
        ]);

        $accountGroup = AccountGroup::where('title', 'My Website')->first();
        $accountGroup->accounts()->saveMany([
            new Account(['name' => 'Email', 'value' => 'info@jane-doe.com', 'value_type' => 'email', 'position' => 0]),
            new Account(['name' => 'Password', 'value' => encrypt('secret'), 'value_type' => 'password', 'position' => 1]),
            new Account(['name' => 'Link', 'value' => 'http://www.my-website.com/login', 'value_type' => 'link', 'position' => 2])
        ]);

        $accountGroup = AccountGroup::where('title', 'Ftp')->first();
        $accountGroup->accounts()->saveMany([
            new Account(['name' => 'Email', 'value' => 'info@jane-doe.com', 'value_type' => 'email', 'position' => 0]),
            new Account(['name' => 'Password', 'value' => encrypt('secret'), 'value_type' => 'password', 'position' => 1]),
            new Account(['name' => 'Link', 'value' => 'http://ftp.my-website.com/login', 'value_type' => 'link', 'position' => 2])
        ]);

        // Jane Doe Gifts
        //-------------------------------------
        $accountGroup = AccountGroup::where('title', 'Shop')->first();
        $accountGroup->accounts()->saveMany([
            new Account(['name' => 'Email', 'value' => 'info@gift-shop.com', 'value_type' => 'email', 'position' => 0]),
            new Account(['name' => 'Password', 'value' => encrypt('secret'), 'value_type' => 'password', 'position' => 1]),
            new Account(['name' => 'Link', 'value' => 'http://www.shop.com/app/login', 'value_type' => 'link', 'position' => 2])
        ]);

        $accountGroup = AccountGroup::where('title', 'Subscription')->first();
        $accountGroup->accounts()->saveMany([
            new Account(['name' => 'Email', 'value' => 'info@subscription.com', 'value_type' => 'email', 'position' => 0]),
            new Account(['name' => 'Password', 'value' => encrypt('secret'), 'value_type' => 'password', 'position' => 1]),
            new Account(['name' => 'Link', 'value' => 'http://www.subscription.com/login', 'value_type' => 'link', 'position' => 2])
        ]);

        // John Doe Social
        //-------------------------------------
        $accountGroup = AccountGroup::where('title', 'Pinterest')->first();
        $accountGroup->accounts()->saveMany([
            new Account(['name' => 'Email', 'value' => 'info@gmail.com', 'value_type' => 'email', 'position' => 0]),
            new Account(['name' => 'Password', 'value' => encrypt('secret'), 'value_type' => 'password', 'position' => 1]),
            new Account(['name' => 'Link', 'value' => 'http://www.pinterest.com/login', 'value_type' => 'link', 'position' => 2])
        ]);

        $accountGroup = AccountGroup::where('title', 'Account')->first();
        $accountGroup->accounts()->saveMany([
            new Account(['name' => 'Email', 'value' => 'info@account.com', 'value_type' => 'email', 'position' => 0]),
            new Account(['name' => 'Password', 'value' => encrypt('secret'), 'value_type' => 'password', 'position' => 1]),
            new Account(['name' => 'Link', 'value' => 'http://www.account.com/login', 'value_type' => 'link', 'position' => 2])
        ]);

        // John Doe Forum
        //-------------------------------------
        $accountGroup = AccountGroup::where('title', 'Twitter')->first();
        $accountGroup->accounts()->saveMany([
            new Account(['name' => 'Email', 'value' => 'info@forum.com', 'value_type' => 'email', 'position' => 0]),
            new Account(['name' => 'Password', 'value' => encrypt('secret'), 'value_type' => 'password', 'position' => 1]),
            new Account(['name' => 'Link', 'value' => 'http://www.twitter.com/login', 'value_type' => 'link', 'position' => 2])
        ]);

        $accountGroup = AccountGroup::where('title', 'The Forum')->first();
        $accountGroup->accounts()->saveMany([
            new Account(['name' => 'Email', 'value' => 'info@forum.com', 'value_type' => 'email', 'position' => 0]),
            new Account(['name' => 'Password', 'value' => encrypt('secret'), 'value_type' => 'password', 'position' => 1]),
            new Account(['name' => 'Link', 'value' => 'http://www.forum.com/login', 'value_type' => 'link', 'position' => 2])
        ]);
    }
}
