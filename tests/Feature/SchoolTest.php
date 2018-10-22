<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use sifmedtec\Theme;
use sifmedtec\School;

class SchoolTest extends TestCase
{
    use RefreshDatabase;

    function test_school_list()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(School::class)->create(['name' => '3 de abril']);

        $this->getJson('/api/schools')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['name' => '3 de abril']
                ]
            ]);
    }

    function test_search_school_by_name()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(School::class)->create(['name' => 'Normal']);
        factory(School::class)->create(['name' => '3 de abril']);

        $this->call('GET', '/api/schools', ['name' => 'ab'])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['name' => '3 de abril']
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    1 => ['name' => 'Normal']
                ]
            ]);
    }

    function test_store_school()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->defaultUser(), 'api');
        $school = factory(School::class)->make();
        $params = [
            'name'            => $school->name,
            'city_id'         => $school->city_id,
            'principal_name'  => $school->principal_name,
            'principal_phone' => $school->principal_phone,
            'principal_email' => $school->principal_email,
            'phone'           => $school->phone,
            'other_phone'     => $school->other_phone,
            'teachers'        => $school->teachers,
            'email'           => $school->email,
        ];

        $this->postJson('/api/schools', $params)
            ->assertStatus(201)
            ->assertJson([
                'data' => ['name' => $school->name]
            ]);

        $this->assertDatabaseHas('schools', [
            'name' => $school->name,
            'city_id' =>  $school->city_id
        ]);
    }

    function test_validate_unique_name_on_store_school()
    {
        $this->actingAs($this->defaultUser(), 'api');
        factory(School::class)->create(['name' => 'Hardware']);

        $params = ['name' => 'Hardware'];

        $this->postJson('/api/schools', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['nombre ya ha sido registrado.']]
            ]);
    }

    function test_validate_store_school()
    {
        $this->actingAs($this->defaultUser(), 'api');

        $params = [];

        $this->postJson('/api/schools', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['El campo nombre es obligatorio.']]
            ]);
    }

    function test_update_school()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $theme = factory(School::class)->create(['name' => 'Hardware']);

         $params = [
            'name' => 'Politica',
            'area_id' =>  $theme->area_id
        ];

         $this->putJson('/api/schools/'.$theme->id, $params)
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => 'Politica']
            ]);

        $this->assertDatabaseHas('schools', ['name' => 'Politica']);
    }

    function test_validate_update_school()
    {
         //$this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $theme = factory(School::class)->create();

         $params = [];

        $this->putJson('/api/schools/'.$theme->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['El campo nombre es obligatorio.']]
            ]);
    }

    function test_validate_unique_name_on_update_school()
    {
         //$this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $other_school = factory(School::class)->create(['name' => 'Hardware']);
         $theme = factory(School::class)->create();

         $params = ['name' => 'Hardware'];

        $this->putJson('/api/schools/'.$theme->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['nombre ya ha sido registrado.']]
            ]);
    }

    function test_can_use_same_name_on_update_school()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $theme = factory(School::class)->create(['name' => 'Hardware']);

         $params = ['name' => 'Hardware', 'area_id' => $theme->area_id];

         $this->putJson('/api/schools/'.$theme->id, $params)
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => 'Hardware']
            ]);

        $this->assertDatabaseHas('schools', ['name' => 'Hardware']);
    }

    function test_destroy_school()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $theme = factory(School::class)->create();

         $this->deleteJson('/api/schools/'.$theme->id)
            ->assertStatus(204);

        $this->assertDatabaseMissing('schools', ['id' => $theme->id]);
    }
}
