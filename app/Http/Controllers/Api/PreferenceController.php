<?php

namespace sifmedtec\Http\Controllers\Api;

use Illuminate\Http\Request;
use sifmedtec\Http\Controllers\Controller;
use sifmedtec\Preference;
use sifmedtec\Http\Resources\PreferenceResource;
use sifmedtec\Http\Requests\PreferenceUpdate;
use PhpParser\DummyNode;

class PreferenceController extends Controller
{

    public function show(Preference $preference)
    {
        return new PreferenceResource($preference);
    }

    public function update(PreferenceUpdate $request, Preference $preference)
    {
         $preference->update(request()->only([
                'question_area',
                'answers_question',
                'number_capacitation_plan_1',
                'number_capacitation_plan_2',
                'number_capacitation_plan_3',
                'number_capacitation_plan_4',
            ]));

         return new PreferenceResource($preference);
    }
}
