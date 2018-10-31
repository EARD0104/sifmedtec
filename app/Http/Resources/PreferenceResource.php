<?php

namespace sifmedtec\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PreferenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'question_area'              => $this->question_area,
            'answers_question'           => $this->answers_question,
            'number_capacitation_plan_1' => $this->number_capacitation_plan_1,
            'number_capacitation_plan_2' => $this->number_capacitation_plan_2,
            'number_capacitation_plan_3' => $this->number_capacitation_plan_3,
            'number_capacitation_plan_4' => $this->number_capacitation_plan_4,
        ];
    }
}
