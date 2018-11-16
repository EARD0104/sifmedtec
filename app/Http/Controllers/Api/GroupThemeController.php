<?php

namespace sifmedtec\Http\Controllers\Api;

use Illuminate\Http\Request;
use sifmedtec\Http\Controllers\Controller;
use sifmedtec\Group;
use sifmedtec\Preference;
use sifmedtec\Http\Resources\GroupAreaResource;
use sifmedtec\Http\Resources\GroupResource;
use sifmedtec\Theme;

class GroupThemeController extends Controller
{
    public function store(Request $request, Group $group)
    {
        //Obtenemos las preferencias del sistema
        $preferences   = Preference::first();
        //Obtenemos los resultados de las evaluaciones por área
        $areas_results = GroupAreaResource::collection($group->areas_results);

        //recorremos cada área
        foreach ($areas_results as $area) {
            //obtenemos el porcentaje del resultado por área
            $percent = ($area->corrects / $area->total) * 100;
            $themes_quantity = 0;
            //realizamos la verificación para validar  la cantidad de temas por área a guardar
            if ($percent <= 25) {
                $themes_quantity =$preferences->number_capacitation_plan_1;
            }

            if ($percent > 25 && $percent < 60) {
                $themes_quantity =$preferences->number_capacitation_plan_2;
            }

            if ($percent >= 60  && $percent <= 85) {
                $themes_quantity =$preferences->number_capacitation_plan_3;
            }

            if ($percent > 85 ) {
                $themes_quantity =$preferences->number_capacitation_plan_4;
            }

            //obtenemos de forma random los themas a asignar
            $themes = Theme::where('area_id', $area->id)->inRandomOrder()->take($themes_quantity)->pluck('id');
            //asignamos al grupo los temas por área
            $group->themes()->attach($themes);
        }
        //retornamos la colección de datos resultantes
        return new GroupResource($group);


    }
}
