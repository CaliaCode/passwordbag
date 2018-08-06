<?php

/*
|--------------------------------------------------------------------------
| Account Factories
|--------------------------------------------------------------------------
|
| Here we set the account factory.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'          => $faker->name,
        'value'         => $faker->safeEmail,
        'value_type'    => $password ?: $password = bcrypt('secret'),
        'position'      => str_random(10),
    ];
});
