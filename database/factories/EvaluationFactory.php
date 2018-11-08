<?php

use Faker\Generator as Faker;
use sifmedtec\Evaluation;
use sifmedtec\Group;

$factory->define(Evaluation::class, function (Faker $faker) {
    return [
        'teacher_name' => $faker->name,
        'teacher_dpi'  => $faker->numberBetween($min = 100000000000, $max = 900000000000),
        'group_id'     => function ()
        {
            return factory(Group::class)->create()->id;
        },
    ];
});
