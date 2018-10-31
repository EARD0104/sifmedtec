<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use sifmedtec\Preference;

class PreferenceTest extends TestCase
{
    use RefreshDatabase;


    function test_update_preference()
    {
         $this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $preference = factory(Preference::class)->create();

         $params = [
            'question_area' => $preference->question_area,
            'answers_question' => $preference->answers_question,
            'number_capacitation_plan_1' => $preference->number_capacitation_plan_1,
            'number_capacitation_plan_2' => $preference->number_capacitation_plan_2,
            'number_capacitation_plan_3' => $preference->number_capacitation_plan_3,
            'number_capacitation_plan_4' => $preference->number_capacitation_plan_4,
         ];

         $this->putJson('/api/preferences/'.$preference->id, $params)
            ->assertStatus(200);

        $this->assertDatabaseHas('preferences', [
            'question_area' => $preference->question_area,
            'answers_question' => $preference->answers_question,
            'number_capacitation_plan_1' => $preference->number_capacitation_plan_1,
            'number_capacitation_plan_2' => $preference->number_capacitation_plan_2,
            'number_capacitation_plan_3' => $preference->number_capacitation_plan_3,
            'number_capacitation_plan_4' => $preference->number_capacitation_plan_4,
        ]);
    }


}
