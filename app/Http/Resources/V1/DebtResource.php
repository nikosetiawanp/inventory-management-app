<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DebtResource extends JsonResource
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
            "amount" => $this->amount,
            "type" => $this->type,
            "isPaid" => $this->is_paid,
            "invoiceId" => $this->invoice_id,
            "contactId" => $this->contact_id,

            "invoice" => new InvoiceResource($this->whenLoaded("invoice")),
            "contact" => new ContactResource($this->whenLoaded("contact")),
            "payments" => PaymentResource::collection($this->whenLoaded("payments")),
        ];
    }
}
