<?php

namespace sifmedtec\Http\Controllers;

use Illuminate\Http\Request;
use sifmedtec\Preference;
use sifmedtec\Area;
use sifmedtec\Http\Resources\AreaEvaluationResource;

class EvaluationQuestionController extends Controller
{
    public function index()
    {

        $areas = Area::all();
        return AreaEvaluationResource::collection($areas);
    }
}
