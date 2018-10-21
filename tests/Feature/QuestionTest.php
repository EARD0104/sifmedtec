<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use sifmedtec\Question;

class QuestionsTest extends TestCase
{
    use RefreshDatabase;

    function test_questions_list()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(Question::class)->create(['name' => '¿ Cual de las siguientes ?']);

        $this->getJson('/api/questions')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['name' => '¿ Cual de las siguientes ?']
                ]
            ]);

    }

    function test_search_questions_by_name()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(Question::class)->create(['name' => '¿Politica?']);
        factory(Question::class)->create(['name' => '¿ Cual de las siguientes ?']);

        $this->call('GET', '/api/questions', ['name' => 'cu'])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['name' => '¿ Cual de las siguientes ?']
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    1 => ['name' => '¿Politica?']
                ]
            ]);
    }

    function test_store_questions()
    {
        $this->actingAs($this->defaultUser(), 'api');
        $question = factory(Question::class)->make();
        $params = [
            'name' => $question->name,
            'area_id' =>  $question->area_id
        ];

        $this->postJson('/api/questions', $params)
            ->assertStatus(201)
            ->assertJson([
                'data' => ['name' => $question->name]
            ]);

        $this->assertDatabaseHas('questions', [
            'name' => $question->name,
            'area_id' =>  $question->area_id
        ]);
    }

    function test_validate_unique_name_on_store_questions()
    {
        $this->actingAs($this->defaultUser(), 'api');
        factory(Question::class)->create(['name' => '¿Cual de las siguientes?']);

        $params = ['name' => '¿Cual de las siguientes?'];

        $this->postJson('/api/questions', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['nombre ya ha sido registrado.']]
            ]);
    }

    function test_validate_store_questions()
    {
        $this->actingAs($this->defaultUser(), 'api');

        $params = [];

        $this->postJson('/api/questions', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['El campo nombre es obligatorio.']]
            ]);
    }

    function test_update_questions()
    {
         $this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $question = factory(Question::class)->create(['name' => '¿Cual de las siguientes?']);

         $params = [
            'name' => '¿Politica?',
            'area_id' =>  $question->area_id
        ];

         $this->putJson('/api/questions/'.$question->id, $params)
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => '¿Politica?']
            ]);

        $this->assertDatabaseHas('questions', ['name' => '¿Politica?']);
    }

    function test_validate_update_questions()
    {
         //$this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $question = factory(Question::class)->create();

         $params = [];

        $this->putJson('/api/questions/'.$question->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['El campo nombre es obligatorio.']]
            ]);
    }

    function test_validate_unique_name_on_update_questions()
    {
         //$this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $other_questions = factory(Question::class)->create(['name' => '¿ Cual de las siguientes ?']);
         $question = factory(Question::class)->create();

         $params = ['name' => '¿ Cual de las siguientes ?'];

        $this->putJson('/api/questions/'.$question->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['nombre ya ha sido registrado.']]
            ]);
    }

    function test_can_use_same_name_on_update_questions()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $question = factory(Question::class)->create(['name' => '¿ Cual de las siguientes ?']);

         $params = ['name' => '¿ Cual de las siguientes ?', 'area_id' => $question->area_id];

         $this->putJson('/api/questions/'.$question->id, $params)
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => '¿ Cual de las siguientes ?']
            ]);

        $this->assertDatabaseHas('questions', ['name' => '¿ Cual de las siguientes ?']);
    }

    function test_destroy_questions()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $question = factory(Question::class)->create();

         $this->deleteJson('/api/questions/'.$question->id)
            ->assertStatus(204);

        $this->assertDatabaseMissing('questions', ['id' => $question->id]);
    }
}
