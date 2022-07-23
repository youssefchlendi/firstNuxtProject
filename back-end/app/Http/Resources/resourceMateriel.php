<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class resourceMateriel extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $colors =  ["green", "purple", "indigo", "cyan", "teal", "orange"];

        return [
            'id' => $this->id,
            'text' => $this->name,
            'responsable_id' => $this->responsable_id,
            'responsable' => $this->responsable->first_name . ' ' . $this->responsable->last_name,
            'color' => $colors[array_rand($colors)],
        ];
    }
}
