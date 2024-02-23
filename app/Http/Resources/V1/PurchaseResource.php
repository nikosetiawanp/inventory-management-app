<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "number" => $this->number,
            "date" => $this->date,
            "expectedArrival" => $this->expected_arrival,
            "isApproved" => $this->is_approved,
            "contactId" => $this->contact_id,
            "contact" => new ContactResource($this->whenLoaded("contact")),
            "purchaseItems" => PurchaseItemResource::collection($this->whenLoaded("purchaseItems")),
        ];
    }
}
