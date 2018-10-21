<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use sifmedtec\Theme;

class ThemeTest extends TestCase
{
    use RefreshDatabase;

    function test_theme_list()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(Theme::class)->create(['name' => 'Hardware']);

        $this->getJson('/api/themes')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['name' => 'Hardware']
                ]
            ]);

    }

    function test_search_theme_by_nae()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        factory(Theme::class)->create(['name' => 'Politica']);
        factory(Theme::class)->create(['name' => 'Hardware']);

        $this->call('GET', '/api/themes', ['name' => 'ha'])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['name' => 'Hardware']
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    1 => ['name' => 'Politica']
                ]
            ]);
    }

    function test_store_theme()
    {
        $this->actingAs($this->defaultUser(), 'api');
        $theme = factory(Theme::class)->make();
        $params = [
            'name' => $theme->name,
            'area_id' =>  $theme->area_id
        ];

        $this->postJson('/api/themes', $params)
            ->assertStatus(201)
            ->assertJson([
                'data' => ['name' => $theme->name]
            ]);

        $this->assertDatabaseHas('themes', [
            'name' => $theme->name,
            'area_id' =>  $theme->area_id
        ]);
    }

    function test_validate_unique_name_on_store_theme()
    {
        $this->actingAs($this->defaultUser(), 'api');
        factory(Theme::class)->create(['name' => 'Hardware']);

        $params = ['name' => 'Hardware'];

        $this->postJson('/api/themes', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['nombre ya ha sido registrado.']]
            ]);
    }

    function test_validate_store_theme()
    {
        $this->actingAs($this->defaultUser(), 'api');

        $params = [];

        $this->postJson('/api/themes', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['El campo nombre es obligatorio.']]
            ]);
    }

    function test_update_theme()
    {
         $this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $theme = factory(Theme::class)->create(['name' => 'Hardware']);

         $params = [
            'name' => 'Politica',
            'area_id' =>  $theme->area_id
        ];

         $this->putJson('/api/themes/'.$theme->id, $params)
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => 'Politica']
            ]);

        $this->assertDatabaseHas('themes', ['name' => 'Politica']);
    }

    function test_validate_update_theme()
    {
         //$this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $theme = factory(Theme::class)->create();

         $params = [];

        $this->putJson('/api/themes/'.$theme->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['El campo nombre es obligatorio.']]
            ]);
    }

    function test_validate_unique_name_on_update_theme()
    {
         //$this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $other_theme = factory(Theme::class)->create(['name' => 'Hardware']);
         $theme = factory(Theme::class)->create();

         $params = ['name' => 'Hardware'];

        $this->putJson('/api/themes/'.$theme->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['name' => ['nombre ya ha sido registrado.']]
            ]);
    }

    function test_can_use_same_name_on_update_theme()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $theme = factory(Theme::class)->create(['name' => 'Hardware']);

         $params = ['name' => 'Hardware', 'area_id' => $theme->area_id];

         $this->putJson('/api/themes/'.$theme->id, $params)
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => 'Hardware']
            ]);

        $this->assertDatabaseHas('themes', ['name' => 'Hardware']);
    }

    function test_destroy_theme()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $theme = factory(Theme::class)->create();

         $this->deleteJson('/api/themes/'.$theme->id)
            ->assertStatus(204);

        $this->assertDatabaseMissing('themes', ['id' => $theme->id]);
    }
}
