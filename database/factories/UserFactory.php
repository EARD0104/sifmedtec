<?php

use Faker\Generator as Faker;
use sifmedtec\Role;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(sifmedtec\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => 'secret',
        'remember_token' => str_random(10),
        'api_token' => str_random(100),
        'role_id' => function ()
        {
            return factory(Role::class)->create()->id;
        }


    ];
});
