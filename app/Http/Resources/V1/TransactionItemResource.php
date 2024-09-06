<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionItemResource extends JsonResource
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
            "price" => $this->price,
            "discount" => $this->discount,
            "tax" => $this->tax,
            "transactionId" => $this->transaction_id,
            "productId" => $this->product_id,

            "product" => new ProductResource($this->whenLoaded("product")),
            "inventoryItems" => InventoryItemResource::collection($this->whenLoaded("inventoryItems")),
        ];
    }
}
