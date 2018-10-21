<?php

use Faker\Generator as Faker;

$factory->define(sifmedtec\Department::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
