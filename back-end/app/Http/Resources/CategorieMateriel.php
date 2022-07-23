<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategorieMateriel extends JsonResource
{
    /**
     * Transform the resource collection into an array.
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
            'color' => $colors[array_rand($colors)],
        ];
    }
}
