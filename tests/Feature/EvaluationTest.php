<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use sifmedtec\Evaluation;

class EvaluationTest extends TestCase
{
    use RefreshDatabase;

    function test_store_evaluation()
    {
        $this->actingAs($this->defaultUser(), 'api');
        $evaluation = factory(Evaluation::class)->make();
        $params = [
            'teacher_name' => $evaluation->teacher_name,
            'teacher_dpi'  => $evaluation->teacher_dpi,
            'group_id'     => $evaluation->group_id,
        ];

        $this->postJson('/evaluations', $params)
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'teacher_name' => $evaluation->teacher_name,
                    'teacher_dpi'  => $evaluation->teacher_dpi,
                ]
            ]);

        $this->assertDatabaseHas('evaluations', [
            'teacher_name' => $evaluation->teacher_name,
            'teacher_dpi'  => $evaluation->teacher_dpi,
            'group_id'     => $evaluation->group_id,
        ]);
    }

    function test_validate_store_evaluation()
    {
        $this->actingAs($this->defaultUser(), 'api');
        $params = [];

        $this->postJson('/evaluations', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'teacher_name' => ['El campo nombre es obligatorio.'],
                    'teacher_dpi'  => ['El campo dpi es obligatorio.'],
                    'group_id'     => ['El campo grupo es obligatorio.'],
                ]
            ]);

    }

    function test_validate_unique_teacher_evaluation()
    {
        $this->actingAs($this->defaultUser(), 'api');
        $evaluation = factory(Evaluation::class)->create();
        $params = [
            'teacher_name' => $evaluation->teacher_name,
            'teacher_dpi'  => $evaluation->teacher_dpi,
            'group_id'     => $evaluation->group_id,
        ];

        $this->postJson('/evaluations', $params)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'teacher_dpi'  => ['Ya existe una evaluación en este grupo con este dpi'],
                ]
            ]);
    }
}
