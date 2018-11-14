<?php

namespace sifmedtec\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use sifmedtec\Preference;

class AreaEvaluationResource extends JsonResource
{

    public function toArray($request)
    {
        //obtenemos las preferencias del sistema
        $preferences = Preference::first();
        //crear un listado ordenado de forma random y seleccionamos el número de preguntas
        //según preferencias
        $questions = $this->questions()->inRandomOrder()->take($preferences->question_area)->get();

        //recorremos cada pregunta para obtener el las respuestas
        foreach ($questions as $question) {
            //seleccionamos las respuestas incorrectas - 1
            $answers    = $question->answers()->where('is_the_answer', false)->inRandomOrder()->take($preferences->answers_question - 1)->get();
            //seleccionamos las respuestas correctas
            $the_answer = $question->answers()->where('is_the_answer', true)->inRandomOrder()->limit(1)->get();
            //unimos las dos busquedas en una sola colección de datos
            $answers    = $answers->merge($the_answer);
            //ordenamos las respuestas de forma random
            $answers    = $answers->shuffle();
            //agregamos las respuestas a la pregunta
            $question->answers_to_evaluate = $answers;

        }

        //retornamos el área con las preguntas y respuestas a ser evaluadas
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'questions'   => QuestionResource::collection($questions),
            'answers'     => []
        ];
    }
}
