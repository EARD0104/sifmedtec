<?php

namespace sifmedtec\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'     => $this->id,
            'name'   => $this->name,
            'email'  => $this->email,
            'role'   => new RoleResource($this->whenLoaded('role')),
            'school' => $this->schools->count() > 0 ? new SchoolResource($this->schools->first()): [],
        ];
    }
}
