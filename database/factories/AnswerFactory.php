<?php

use Faker\Generator as Faker;
use sifmedtec\Question;

$factory->define(sifmedtec\Answer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'question_id' => function(){
            return factory(Question::class)->create()->id;
        }
    ];
});
