<?php

namespace sifmedtec\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
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
            'city'            => new CityResource($this->whenLoaded('city')),
            'principal_name'  => $this->principal_name,
            'principal_phone' => $this->principal_phone,
            'principal_email' => $this->principal_email,
            'phone'           => $this->phone,
            'other_phone'     => $this->other_phone,
            'teachers'        => $this->teachers,
            'email'           => $this->email,
        ];
    }
}
