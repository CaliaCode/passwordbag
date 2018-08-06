<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->delete();

        Category::create(['name' => 'Ftp', 'position' => 0]);

        Category::create(['name' => 'Login', 'position' => 1]);

        Category::create(['name' => 'Social', 'position' => 2]);

        Category::create(['name' => 'Website', 'position' => 3]);
    }
}
