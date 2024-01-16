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
            "vendorId" => $this->vendor_id,
            "prNumber" => $this->pr_number,
            "prDate" => $this->pr_date,
            "poNumber" => $this->po_number,
            "poDate" => $this->po_date,
            "status" => $this->status,
            "vendor" => new VendorResource($this->whenLoaded("vendor")),
            "purchaseItems" => PurchaseItemResource::collection($this->whenLoaded("purchaseItems")),
        ];
    }
}
