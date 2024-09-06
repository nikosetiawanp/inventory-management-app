<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryItemResource extends JsonResource
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
            "quantity" => $this->quantity,
            "productId" => $this->product_id,
            "inventoryId" => $this->inventory_id,
            "transactionItemId" => $this->transaction_item_id,

            "product" => new ProductResource($this->whenLoaded("product")),
            "inventory" => new InventoryResource($this->whenLoaded("inventory")),
            "transactionItem" => new TransactionItemResource($this->whenLoaded("transactionItem")),
        ];
    }
}
