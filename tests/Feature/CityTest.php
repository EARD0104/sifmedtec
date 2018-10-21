<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use sifmedtec\City;

class CityTest extends TestCase
{
    use RefreshDatabase;

    function test_city_list()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(City::class)->create(['name' => 'San Benito']);

        $this->getJson('/api/cities')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['name' => 'San Benito']
                ]
            ]);

    }

    function test_search_city_by_nae()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(City::class)->create(['name' => 'Flores']);
        factory(City::class)->create(['name' => 'San Benito']);

        $this->call('GET', '/api/cities', ['name' => 'sa'])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['name' => 'San Benito']
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    1 => ['name' => 'Flores']
                ]
            ]);
    }

    function test_store_city()
    {
        $this->actingAs($this->defaultUser(), 'api');
        $city = factory(City::class)->make();
        $params = [
            'name' => $city->name,
            'department_id' =>  $city->department_id
        ];

        $this->postJson('/api/cities', $params)
            ->assertStatus(201)
            ->assertJson([
                'data' => ['name' => $city->name]
            ]);

        $this->assertDatabaseHas('cities', [
            'name' => $city->name,
            'department_id' =>  $city->department_id
        ]);
    }

    function test_validate_unique_name_on_store_city()
    {
        $this->actingAs($this->defaultUser(), 'api');
        factory(City::class)->create(['name' => 'San Benito']);

        $params = ['name' => 'San Benito'];

        $this->postJson('/api/cities', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['nombre ya ha sido registrado.']]
            ]);
    }

    function test_validate_store_city()
    {
        $this->actingAs($this->defaultUser(), 'api');

        $params = [];

        $this->postJson('/api/cities', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['El campo nombre es obligatorio.']]
            ]);
    }

    function test_update_city()
    {
         $this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $city = factory(City::class)->create(['name' => 'San Benito']);

         $params = [
            'name' => 'Flores',
            'department_id' =>  $city->department_id
        ];

         $this->putJson('/api/cities/'.$city->id, $params)
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => 'Flores']
            ]);

        $this->assertDatabaseHas('cities', ['name' => 'Flores']);
    }

    function test_validate_update_city()
    {
         //$this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $city = factory(City::class)->create();

         $params = [];

        $this->putJson('/api/cities/'.$city->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['El campo nombre es obligatorio.']]
            ]);
    }

    function test_validate_unique_name_on_update_city()
    {
         //$this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $other_city = factory(City::class)->create(['name' => 'San Benito']);
         $city = factory(City::class)->create();

         $params = ['name' => 'San Benito'];

        $this->putJson('/api/cities/'.$city->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['nombre ya ha sido registrado.']]
            ]);
    }

    function test_can_use_same_name_on_update_city()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $city = factory(City::class)->create(['name' => 'San Benito']);

         $params = ['name' => 'San Benito', 'department_id' => $city->department_id];

         $this->putJson('/api/cities/'.$city->id, $params)
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => 'San Benito']
            ]);

        $this->assertDatabaseHas('cities', ['name' => 'San Benito']);
    }

    function test_destroy_city()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $city = factory(City::class)->create();

         $this->deleteJson('/api/cities/'.$city->id)
            ->assertStatus(204);

        $this->assertDatabaseMissing('cities', ['id' => $city->id]);
    }
}
