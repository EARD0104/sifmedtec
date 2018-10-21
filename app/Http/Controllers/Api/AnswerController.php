<?php

namespace sifmedtec\Http\Controllers\Api;

use Illuminate\Http\Request;
use sifmedtec\Http\Controllers\Controller;
use sifmedtec\Answer;
use sifmedtec\Http\Resources\AnswerResource;
use sifmedtec\Http\Requests\AnswerStore;
use sifmedtec\Http\Requests\AnswerUpdate;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $answers = Answer::name()->question()->orderByDesc('question_id')->with('question')->paginateIf();
        return AnswerResource::collection($answers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnswerStore $request)
    {
        $answer = Answer::create(request()->only('name', 'question_id', 'is_the_answer'));
        return new AnswerResource($answer);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnswerUpdate $request, Answer $answer)
    {
        $answer->update(request()->only('name', 'question_id', 'is_the_answer'));
        return new AnswerResource($answer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        $answer->delete();
        return response()->json([], 204);
    }
}
