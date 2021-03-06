<?php

namespace sifmedtec\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use sifmedtec\Preference;

class EvaluationResource extends JsonResource
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
            'id'              => $this->id,
            'teacher_name'    => $this->teacher_name,
            'teacher_dpi'     => $this->teacher_dpi,
            'created_at'      => $this->created_at->format('d/m/Y'),
            'group'           => new GroupResource($this->whenLoaded('group')),
            'correct_percent' => $this->correct_percent
        ];
    }
}
