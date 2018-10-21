<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use sifmedtec\Question;
use sifmedtec\Answer;

class AnswerTest extends TestCase
{
    use RefreshDatabase;

    function test_answers_list()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(Answer::class)->create(['name' => 'esta es una respuesta']);

        $this->getJson('/api/answers')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['name' => 'esta es una respuesta']
                ]
            ]);

    }

    function test_search_answers_by_name()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(Answer::class)->create(['name' => 'esto no']);
        factory(Answer::class)->create(['name' => 'esta es una respuesta']);

        $this->call('GET', '/api/answers', ['name' => 'respuesta'])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['name' => 'esta es una respuesta']
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    1 => ['name' => 'esto no']
                ]
            ]);
    }

    function test_store_answers()
    {
        $this->actingAs($this->defaultUser(), 'api');
        $answer = factory(Answer::class)->make();
        $params = [
            'name' => $answer->name,
            'question_id' =>  $answer->question_id,
            'is_the_answer' => true
        ];

        $this->postJson('/api/answers', $params)
            ->assertStatus(201)
            ->assertJson([
                'data' => ['name' => $answer->name]
            ]);

        $this->assertDatabaseHas('answers', [
            'name' => $answer->name,
            'question_id' =>  $answer->question_id,
            'is_the_answer' => 1
        ]);
    }

    function test_validate_unique_name_on_store_answers()
    {
        $this->actingAs($this->defaultUser(), 'api');
        factory(Answer::class)->create(['name' => '¿Cual de las siguientes?']);

        $params = ['name' => '¿Cual de las siguientes?'];

        $this->postJson('/api/answers', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['nombre ya ha sido registrado.']]
            ]);
    }

    function test_validate_store_answers()
    {
        $this->actingAs($this->defaultUser(), 'api');

        $params = [];

        $this->postJson('/api/answers', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['El campo nombre es obligatorio.']]
            ]);
    }

    function test_update_answers()
    {
         $this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $answer = factory(Answer::class)->create(['name' => '¿Cual de las siguientes?']);

         $params = [
            'name' => 'esta no es una respuesta',
            'question_id' =>  $answer->question_id
        ];

         $this->putJson('/api/answers/'.$answer->id, $params)
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => 'esta no es una respuesta']
            ]);

        $this->assertDatabaseHas('answers', ['name' => 'esta no es una respuesta']);
    }

    function test_validate_update_answers()
    {
         //$this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $answer = factory(Answer::class)->create();

         $params = [];

        $this->putJson('/api/answers/'.$answer->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['El campo nombre es obligatorio.']]
            ]);
    }

    function test_validate_unique_name_on_update_answers()
    {
         //$this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $other_answers = factory(Answer::class)->create(['name' => 'esta es una respuesta']);
         $answer = factory(Answer::class)->create();

         $params = ['name' => 'esta es una respuesta'];

        $this->putJson('/api/answers/'.$answer->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['nombre ya ha sido registrado.']]
            ]);
    }

    function test_can_use_same_name_on_update_answers()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $answer = factory(Answer::class)->create(['name' => 'esta es una respuesta']);

         $params = ['name' => 'esta es una respuesta', 'question_id' => $answer->question_id];

         $this->putJson('/api/answers/'.$answer->id, $params)
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => 'esta es una respuesta']
            ]);

        $this->assertDatabaseHas('answers', ['name' => 'esta es una respuesta']);
    }

    function test_destroy_answers()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $answer = factory(Answer::class)->create();

         $this->deleteJson('/api/answers/'.$answer->id)
            ->assertStatus(204);

        $this->assertDatabaseMissing('answers', ['id' => $answer->id]);
    }
}
