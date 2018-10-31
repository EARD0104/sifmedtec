<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use sifmedtec\Group;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    function test_groups_list()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        $group = factory(Group::class)->create();

        $this->getJson('/api/groups')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => ['id' => $group->id ]
                ]
            ]);

    }

    function test_search_groups_by_name()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->defaultUser(), 'api');
        $group = factory(Group::class)->create();
        factory(Group::class)->create();

        $this->call('GET', '/api/groups', ['school_id' => $group->school_id])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id' => $group->id,
                        'school' => [],
                        'month' => []
                        ]
                ]
            ]);
    }

    function test_store_groups()
    {
        $this->actingAs($this->defaultUser(), 'api');
        $group = factory(Group::class)->make();
        $params = [
            'school_id' => $group->school_id,
            'month_id' =>  $group->month_id,
        ];

        $this->postJson('/api/groups', $params)
            ->assertStatus(201)
            ->assertJson([
                'data' => []
            ]);

        $this->assertDatabaseHas('groups', [
            'school_id' =>  $group->school_id,
            'month_id' =>  $group->month_id,
            'status' => 1
        ]);
    }


    function test_validate_store_groups()
    {
        $this->actingAs($this->defaultUser(), 'api');

        $params = [];

        $this->postJson('/api/groups', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'school_id' => ['El campo escuela es obligatorio.'],
                    'month_id' => ['El campo mes es obligatorio.'],
                ]
            ]);
    }

    function test_update_groups()
    {
         $this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $group = factory(Group::class)->create();
         $other_group = factory(Group::class)->make();

         $params = [
            'school_id' => $other_group->school_id,
            'month_id' => $other_group->month_id,
            'status' => 0
        ];

         $this->putJson('/api/groups/'.$group->id, $params)
            ->assertStatus(200)
            ->assertJson([
                'data' => ['status' => 0]
            ]);

        $this->assertDatabaseHas('groups', [
            'school_id' => $other_group->school_id,
            'month_id' => $other_group->month_id,
            'status' => 0
        ]);
    }

    function test_validate_update_groups()
    {
         //$this->withoutExceptionHandling();
         $this->actingAs($this->defaultUser(), 'api');
         $group = factory(Group::class)->create();

         $params = [];

        $this->putJson('/api/groups/'.$group->id, $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'school_id' => ['El campo escuela es obligatorio.'],
                    'month_id' => ['El campo mes es obligatorio.'],
                ]
            ]);
    }

    function test_destroy_groups()
    {
         $this->actingAs($this->defaultUser(), 'api');
         $group = factory(Group::class)->create();

         $this->deleteJson('/api/groups/'.$group->id)
            ->assertStatus(204);

        $this->assertDatabaseMissing('groups', ['id' => $group->id]);
    }
}
