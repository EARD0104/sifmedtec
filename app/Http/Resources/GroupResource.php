<?php

namespace sifmedtec\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'id'                      => $this->id,
            'school'                  => new SchoolResource($this->whenLoaded('school')),
            'month'                   => new MonthResource($this->whenLoaded('month')),
            'evaluations'             => EvaluationResource::collection($this->whenLoaded('evaluations')),
            'status'                  => $this->status,
            'created_at'              => $this->created_at->format('d-m-Y'),
            'total_answers'           => $this->total_answers,
            'answers_correct'         => $this->answers_correct,
            'answers_correct_percent' => $this->evaluations->count() > 0 ? ( $this->answers_correct / $this->total_answers)  * 100:0,
            'answers_incorrect'       => $this->total_answers - $this->answers_correct,
            'areas_results'           => $this->areas_results,
            'areas'                   => $this->evaluations->count() > 0 ? GroupAreaResource::collection($this->areas_results): [],
            'themes'                  => ThemeResource::collection($this->themes),
        ];
    }
}
