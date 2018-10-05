<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use sifmedtec\User;
use sifmedtec\Role;

class UserTest extends TestCase
{
    use RefreshDatabase;

    function test_user_list()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(User::class)->create(['name' => 'Admin', 'email' => 'admin@admin.com']);

        $this->getJson('/api/users')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['name' => 'Admin']
                ]
            ]);

    }

    function test_search_users()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(User::class)->create(['name' => 'Admin', 'email' => 'admin@admin.com']);

        $this->call('GET', '/api/users', ['name' => 'ad'])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['name' => 'Admin']
                ]
            ]);
    }

    function test_store_users()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        $role = factory(Role::class)->create();
        $params = [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role_id' => $role->id,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $this->postJson('/api/users', $params)
            ->assertStatus(201)
            ->assertJson([
                'data' => ['name' => 'Admin']
            ]);

        $this->assertCredentials($params);
    }

    function test_validate_unique_email_on_store_user()
    {
        //$this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        $role = factory(Role::class)->create(['name' => 'Admin']);
        $user = factory(User::class)->create(['email' => 'admin@admin.com']);

        $params = [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role_id' => $role->id,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $this->postJson('/api/users', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['email' => ['correo electrónico ya ha sido registrado.']]
            ]);
    }

    function test_validate_store_user()
    {
        //$this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');

        $params = [];

        $this->postJson('/api/users', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'name' => ['El campo nombre es obligatorio.'],
                    'email' => ['El campo correo electrónico es obligatorio.'],
                    'role_id' => ['El campo rol es obligatorio.'],
                    'password' => ['El campo contraseña es obligatorio.']
                ]
            ]);
    }


    function test_update_users()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();
        $params = [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role_id' => $role->id,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $this->putJson('/api/users/'.$user->id, $params)
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => 'Admin']
            ]);

        $this->assertCredentials($params);
    }

    function test_validate_unique_email_before_update_users()
    {
        $this->actingAs($this->defaultUser(), 'api');
        $role = factory(Role::class)->create();
        factory(User::class)->create(['email' => 'admin@admin.com',]);
        $user = factory(User::class)->create();
        $params = [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role_id' => $role->id,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $this->putJson('/api/users/'.$user->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['email' => ['correo electrónico ya ha sido registrado.']]
            ]);

        $this->assertInvalidCredentials($params);
    }

    function test_validate_before_update_users()
    {
        $this->actingAs($this->defaultUser(), 'api');
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();
        $params = [];

        $this->putJson('/api/users/'.$user->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'name' => ['El campo nombre es obligatorio.'],
                    'email' => ['El campo correo electrónico es obligatorio.'],
                    'role_id' => ['El campo rol es obligatorio.'],
                    'password' => ['El campo contraseña es obligatorio.']
                ]
            ]);
    }

    function test_destroy_user()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $user = factory(User::class)->create();

         $this->deleteJson('/api/users/'.$user->id)
            ->assertStatus(204);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }


}
