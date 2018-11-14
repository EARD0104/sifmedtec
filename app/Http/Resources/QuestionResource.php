<?php

namespace sifmedtec\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'id'            => $this->id,
            'name'          => $this->name,
            'area'          => new AreaResource($this->whenLoaded('area')),
            'answers'       => AnswerResource::collection($this->whenLoaded('answers')),
            'answers_total' => $this->answers->count(),
            'answers_to_evaluate' => $this->answers_to_evaluate ? $this->answers_to_evaluate: []
        ];
    }
}
