<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Materiel extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'responsable_id' => $this->responsable_id,
            'pivot' => $this->pivot,
            'categories' => CategorieMateriel::collection($this->categorieMateriel),
        ];
    }
}
