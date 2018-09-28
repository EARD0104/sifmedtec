<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use sifmedtec\Role;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    function test_role_list()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(Role::class)->create(['name' => 'Admin']);

        $this->getJson('/api/roles')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['name' => 'Admin']
                ]
            ]);

    }

    function test_search_by_role_list()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(Role::class)->create(['name' => 'Admin']);

        $this->call('GET', '/api/roles', ['name' => 'ad'])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['name' => 'Admin']
                ]
            ]);
    }

    function test_store_role()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');

        $params = ['name' => 'Admin'];

        $this->postJson('/api/roles', $params)
            ->assertStatus(201)
            ->assertJson([
                'data' => ['name' => 'Admin']
            ]);

        $this->assertDatabaseHas('roles', [
            'name' => 'Admin'
        ]);
    }

    function test_validate_unique_name_on_store_role()
    {
        //$this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(Role::class)->create(['name' => 'Admin']);

        $params = ['name' => 'Admin'];

        $this->postJson('/api/roles', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['nombre ya ha sido registrado.']]
            ]);
    }

    function test_validate_store_role()
    {
        //$this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');

        $params = [];

        $this->postJson('/api/roles', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['El campo nombre es obligatorio.']]
            ]);
    }

    function test_update_role()
    {
         $this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $role = factory(Role::class)->create(['name' => 'Admin']);

         $params = ['name' => 'Guest'];

         $this->putJson('/api/roles/'.$role->id, $params)
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => 'Guest']
            ]);

        $this->assertDatabaseHas('roles', ['name' => 'Guest']);
    }

    function test_validate_update_role()
    {
         //$this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $role = factory(Role::class)->create(['name' => 'Admin']);

         $params = [];

        $this->putJson('/api/roles/'.$role->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['El campo nombre es obligatorio.']]
            ]);
    }

    function test_validate_unique_name_on_update_role()
    {
         //$this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $other_role = factory(Role::class)->create(['name' => 'Admin']);
         $role = factory(Role::class)->create();

         $params = ['name' => 'Admin'];

        $this->putJson('/api/roles/'.$role->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['nombre ya ha sido registrado.']]
            ]);
    }

    function test_can_use_same_name_on_update_role()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $role = factory(Role::class)->create(['name' => 'Admin']);

         $params = ['name' => 'Admin', 'description' => 'Hola mundo'];

         $this->putJson('/api/roles/'.$role->id, $params)
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => 'Admin']
            ]);

        $this->assertDatabaseHas('roles', ['name' => 'Admin', 'description' => 'Hola mundo']);
    }

    function test_destroy_role()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $role = factory(Role::class)->create();

         $this->deleteJson('/api/roles/'.$role->id)
            ->assertStatus(204);

        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }


}
