<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class demandeMaterielRessource extends JsonResource
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
            'user_id' => $this->user_id,
            'responsable_id' => $this->responsable_id,
            'responsable' => $this->responsable,
            'user'=>$this->user,
            'date_demande' => $this->date_demande,
            'date_fin_demande' => $this->date_fin_demande,
            'created_at' => $this->created_at,
            'message' => $this->message,
            'materiels' => Materiel::collection($this->materiels),
            'materielEdit' => resourceMateriel::collection($this->materiels),
        ];
    }
}
