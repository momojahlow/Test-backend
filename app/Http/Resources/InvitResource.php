<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id' => (string)$this->id,
            'societe_id' => $this->societe_id,
            'email' => $this->email,
            'token' => $this->token,
            'date' => $this->created_at->format('d/m/Y') ,
            'notes' => $this->note,
            'societe' => new SocieteResource($this->whenLoaded('societe')),
        ];
    }
}
