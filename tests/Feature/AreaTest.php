<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use sifmedtec\Area;

class AreaTest extends TestCase
{
    use RefreshDatabase;

    function test_area_list()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(Area::class)->create(['name' => 'Hardware']);

        $this->getJson('/api/areas')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['name' => 'Hardware']
                ]
            ]);

    }

    function test_search_by_area_list()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(Area::class)->create(['name' => 'Hardware']);

        $this->call('GET', '/api/areas', ['name' => 'ha'])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['name' => 'Hardware']
                ]
            ]);
    }

    function test_store_area()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');

        $params = ['name' => 'Hardware'];

        $this->postJson('/api/areas', $params)
            ->assertStatus(201)
            ->assertJson([
                'data' => ['name' => 'Hardware']
            ]);

        $this->assertDatabaseHas('areas', [
            'name' => 'Hardware'
        ]);
    }

    function test_validate_unique_name_on_store_area()
    {
        //$this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(Area::class)->create(['name' => 'Hardware']);

        $params = ['name' => 'Hardware'];

        $this->postJson('/api/areas', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['nombre ya ha sido registrado.']]
            ]);
    }

    function test_validate_store_area()
    {
        //$this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');

        $params = [];

        $this->postJson('/api/areas', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['El campo nombre es obligatorio.']]
            ]);
    }

    function test_update_area()
    {
         $this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $area = factory(Area::class)->create(['name' => 'Hardware']);

         $params = ['name' => 'Guest'];

         $this->putJson('/api/areas/'.$area->id, $params)
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => 'Guest']
            ]);

        $this->assertDatabaseHas('areas', ['name' => 'Guest']);
    }

    function test_validate_update_area()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $area = factory(Area::class)->create(['name' => 'Hardware']);

         $params = [];

        $this->putJson('/api/areas/'.$area->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['El campo nombre es obligatorio.']]
            ]);
    }

    function test_validate_unique_name_on_update_area()
    {
         //$this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $other_area = factory(Area::class)->create(['name' => 'Hardware']);
         $area = factory(Area::class)->create();

         $params = ['name' => 'Hardware'];

        $this->putJson('/api/areas/'.$area->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['nombre ya ha sido registrado.']]
            ]);
    }

    function test_can_use_same_name_on_update_area()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $area = factory(Area::class)->create(['name' => 'Hardware']);

         $params = ['name' => 'Hardware', 'description' => 'Hola mundo'];

         $this->putJson('/api/areas/'.$area->id, $params)
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => 'Hardware']
            ]);

        $this->assertDatabaseHas('areas', ['name' => 'Hardware', 'description' => 'Hola mundo']);
    }

    function test_destroy_area()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $area = factory(Area::class)->create();

         $this->deleteJson('/api/areas/'.$area->id)
            ->assertStatus(204);

        $this->assertDatabaseMissing('areas', ['id' => $area->id]);
    }


}
