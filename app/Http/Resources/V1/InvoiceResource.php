<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            "dueDate" => $this->due_date,
            "purchaseId" => $this->purchase_id,
            "inventoryId" => $this->inventory_id,

            "purchase" => new PurchaseResource($this->whenLoaded("purchase")),
            "inventory" => new InventoryResource($this->whenLoaded("inventory")),
            "debts" => DebtResource::collection($this->whenLoaded("debts")),
        ];
    }
}
