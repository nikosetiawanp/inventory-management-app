<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
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
            "date" => $this->date,
            "letterNumber" => $this->letter_number,
            "type" => $this->type,
            "description" => $this->description,
            "purchaseId" => $this->purchase_id,

            "purchase" => new PurchaseResource($this->whenLoaded("purchase")),
            "inventoryItems" => InventoryItemResource::collection($this->whenLoaded("inventoryItems")),
        ];
    }
}
