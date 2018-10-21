<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use sifmedtec\Department;

class DepartmentTest extends TestCase
{
    use RefreshDatabase;

    function test_deparment_list()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(Department::class)->create(['name' => 'Petén']);

        $this->getJson('/api/departments')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['name' => 'Petén']
                ]
            ]);

    }

    function test_search_deparment_by_nae()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(Department::class)->create(['name' => 'Zacapa']);
        factory(Department::class)->create(['name' => 'Petén']);

        $this->call('GET', '/api/departments', ['name' => 'pe'])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['name' => 'Petén']
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    1 => ['Zacapa' => 'Petén']
                ]
            ]);
    }

    function test_store_department()
    {
        $this->actingAs($this->defaultUser(), 'api');

        $params = ['name' => 'Petén'];

        $this->postJson('/api/departments', $params)
            ->assertStatus(201)
            ->assertJson([
                'data' => ['name' => 'Petén']
            ]);

        $this->assertDatabaseHas('departments', [
            'name' => 'Petén'
        ]);
    }

    function test_validate_unique_name_on_store_deparment()
    {
        $this->actingAs($this->defaultUser(), 'api');
        factory(Department::class)->create(['name' => 'Petén']);

        $params = ['name' => 'Petén'];

        $this->postJson('/api/departments', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['nombre ya ha sido registrado.']]
            ]);
    }

    function test_validate_store_department()
    {
        $this->actingAs($this->defaultUser(), 'api');

        $params = [];

        $this->postJson('/api/departments', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['El campo nombre es obligatorio.']]
            ]);
    }

    function test_update_deparment()
    {
         $this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $deparment = factory(Department::class)->create(['name' => 'Petén']);

         $params = ['name' => 'Zacapa'];

         $this->putJson('/api/departments/'.$deparment->id, $params)
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => 'Zacapa']
            ]);

        $this->assertDatabaseHas('departments', ['name' => 'Zacapa']);
    }

    function test_validate_update_deparment()
    {
         //$this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $deparment = factory(Department::class)->create();

         $params = [];

        $this->putJson('/api/departments/'.$deparment->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['El campo nombre es obligatorio.']]
            ]);
    }

    function test_validate_unique_name_on_update_deparment()
    {
         //$this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $other_department = factory(Department::class)->create(['name' => 'Petén']);
         $deparment = factory(Department::class)->create();

         $params = ['name' => 'Petén'];

        $this->putJson('/api/departments/'.$deparment->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['nombre ya ha sido registrado.']]
            ]);
    }

    function test_can_use_same_name_on_update_department()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $deparment = factory(Department::class)->create(['name' => 'Petén']);

         $params = ['name' => 'Petén'];

         $this->putJson('/api/departments/'.$deparment->id, $params)
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => 'Petén']
            ]);

        $this->assertDatabaseHas('departments', ['name' => 'Petén']);
    }

    function test_destroy_department()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $deparment = factory(Department::class)->create();

         $this->deleteJson('/api/departments/'.$deparment->id)
            ->assertStatus(204);

        $this->assertDatabaseMissing('departments', ['id' => $deparment->id]);
    }
}
