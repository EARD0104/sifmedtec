<?php

use Faker\Generator as Faker;
use sifmedtec\School;
use sifmedtec\Month;

$factory->define(sifmedtec\Group::class, function (Faker $faker) {
    return [
        'school_id' => function ()
        {
            return factory(School::class)->create()->id;
        },
        'month_id' => function ()
        {
            return factory(Month::class)->create()->id;
        },
    ];
});
