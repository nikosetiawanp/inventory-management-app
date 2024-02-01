<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseItemResource extends JsonResource
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
            "discount" => $this->discount,
            "tax" => $this->tax,
            "prPrice" => $this->pr_price,
            "poPrice" => $this->po_price,
            "purchaseId" => $this->purchase_id,
            "productId" => $this->product_id,

            "product" => new ProductResource($this->whenLoaded("product")),
        ];
    }
}
