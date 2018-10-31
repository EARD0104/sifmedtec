<?php

use Faker\Generator as Faker;

$factory->define(sifmedtec\Preference::class, function (Faker $faker) {
    return [
        'question_area' => $faker->randomDigit,
        'answers_question' => $faker->randomDigit,
        'number_capacitation_plan_1' => $faker->randomDigit,
        'number_capacitation_plan_2' => $faker->randomDigit,
        'number_capacitation_plan_3' => $faker->randomDigit,
        'number_capacitation_plan_4' => $faker->randomDigit,
    ];
});
