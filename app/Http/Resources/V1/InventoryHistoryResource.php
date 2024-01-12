<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;


class InventoryHistoryResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "date" => $this->date,
            "type" => $this->type,
            "description" => $this->description,
            "quantity" => $this->quantity,
            "stockAfter" => $this->stock_after,
            "productId" => $this->product_id,
            "purchaseId" => $this->purchase_id,

            "product" => new ProductResource($this->whenLoaded("product")),
            "purchase" => new PurchaseResource($this->whenLoaded("purchase")),
        ];
    }
}
