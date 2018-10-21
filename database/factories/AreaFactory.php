<?php

use Faker\Generator as Faker;

$factory->define(sifmedtec\Area::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
