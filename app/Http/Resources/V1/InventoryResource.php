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
            "number" => $this->number,
            "date" => $this->date,
            "type" => $this->type,
            "receiptNumber" => $this->receipt_number,
            "description" => $this->description,
            "transactionId" => $this->transaction_id,

            "transaction" => new TransactionResource($this->whenLoaded("transaction")),
            "inventoryItems" => InventoryItemResource::collection($this->whenLoaded("inventoryItems")),
            "invoices" => InvoiceResource::collection($this->whenLoaded("invoices"))
        ];
    }
}
