<?php

use Faker\Generator as Faker;
use sifmedtec\Department;

$factory->define(sifmedtec\City::class, function (Faker $faker) {
    return [
        'department_id' => function(){
            return factory(Department::class)->create()->id;
        },
        'name' => $faker->name,
    ];
});
