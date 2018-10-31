<?php

use Illuminate\Database\Seeder;
use sifmedtec\Preference;

class PreferenceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Preference::create([
            'id' => 1,
            'question_area' => 4,
            'answers_question' => 4,
            'number_capacitation_plan_1' => 1,
            'number_capacitation_plan_2' => 2,
            'number_capacitation_plan_3' => 3,
            'number_capacitation_plan_4' => 4,
        ]);
    }
}
