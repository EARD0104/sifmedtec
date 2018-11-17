<?php

namespace sifmedtec\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupAreaResource extends JsonResource
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
            'name'            => $this->name,
            'total'           => $this->total,
            'corrects'        => $this->corrects,
            'correct_percent' => $this->total > 0 ? ($this->corrects / $this->total) * 100: 0 ,
            'incorrects'      => $this->total - $this->corrects,
        ];
    }
}
