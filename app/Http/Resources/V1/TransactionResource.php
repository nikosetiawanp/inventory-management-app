<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            "type" => $this->type,
            "date" => $this->date,
            "expectedArrival" => $this->expected_arrival,
            "isApproved" => $this->is_approved,
            "isDone" => $this->is_done,
            "contactId" => $this->contact_id,
            "contact" => new ContactResource($this->whenLoaded("contact")),
            "transactionItems" => TransactionItemResource::collection($this->whenLoaded("transactionItems")),
            "inventories" => InventoryItemResource::collection($this->whenLoaded("inventories"))
        ];
    }
}
