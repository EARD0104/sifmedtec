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
        $preferences = Preference::first();
        $areas = Area::has('questions', '>', $preferences->question_area )->get();
        return AreaEvaluationResource::collection($areas);
    }
}
