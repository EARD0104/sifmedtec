<?php

use Faker\Generator as Faker;
use sifmedtec\Area;

$factory->define(sifmedtec\Theme::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'area_id' => function(){
            return factory(Area::class)->create()->id;
        }
    ];
});
