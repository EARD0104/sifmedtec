<?php

use Faker\Generator as Faker;
use sifmedtec\City;

$factory->define(sifmedtec\School::class, function (Faker $faker) {
    return [
        'name'            => $faker->name,
        'city_id'         => function(){
            return factory(City::class)->create()->id;
        },
        'principal_name'  => $faker->name,
        'principal_phone' => $faker->phoneNumber,
        'principal_email' => $faker->email,
        'phone'           => $faker->phoneNumber,
        'other_phone'     => $faker->phoneNumber,
        'teachers'        => $faker->randomDigit,
        'email'           => $faker->email,
    ];
});
