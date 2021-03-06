<?php

namespace sifmedtec\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ThemeResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'area_id' => $this->area_id,
            'area' => new AreaResource($this->whenLoaded('area')),
            'description' => $this->description
        ];
    }
}
