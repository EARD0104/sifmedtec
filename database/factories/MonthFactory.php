<?php

use Faker\Generator as Faker;

$factory->define(sifmedtec\Month::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
