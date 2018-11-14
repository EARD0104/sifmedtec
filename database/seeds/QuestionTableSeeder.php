<?php

use Illuminate\Database\Seeder;
use sifmedtec\Question;
use sifmedtec\Area;
use sifmedtec\Answer;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Area::all() as $area) {
            factory(Question::class)->times(4)->create(['area_id' => $area->id]);
        }

        foreach (Question::all() as $question) {
            factory(Answer::class)->times(4)->create(['question_id' => $question->id]);
        }
    }
}
