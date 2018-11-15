<?php

namespace sifmedtec\Http\Controllers;

use sifmedtec\Evaluation;
use Illuminate\Http\Request;
use sifmedtec\Http\Resources\EvaluationResource;
use sifmedtec\Http\Requests\EvaluationStore;
use sifmedtec\Http\Resources\PreferenceResource;
use sifmedtec\Preference;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EvaluationStore $request)
    {
        return new PreferenceResource(Preference::first());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $evaluation = Evaluation::create(request()->only('teacher_name', 'teacher_dpi', 'group_id'));

        foreach ($request->areas as $area) {
            foreach ($area['answers'] as $answer) {
                $evaluation->details()->create([
                    'area_id'   => $area['id'],
                    'answer_id' => $answer['id'],
                    'answer'    => $answer['is_the_answer']
                ]);
            }
        }

        return new EvaluationResource($evaluation);
    }

    /**
     * Display the specified resource.
     *
     * @param  \sifmedtec\Entities\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function show(Evaluation $evaluation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \sifmedtec\Entities\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function edit(Evaluation $evaluation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \sifmedtec\Entities\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \sifmedtec\Entities\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evaluation $evaluation)
    {
        //
    }
}
