<?php

namespace sifmedtec\Http\Controllers;

use sifmedtec\Evaluation;
use Illuminate\Http\Request;
use sifmedtec\Http\Resources\EvaluationResource;
use sifmedtec\Http\Requests\EvaluationStore;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EvaluationStore $request)
    {
        $evaluation = Evaluation::create(request()->only('teacher_name', 'teacher_dpi', 'group_id'));
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
