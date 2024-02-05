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
            "debtAmount" => $this->debt_amount,
            "status" => $this->status,
            "paidDate" => $this->paid_date,
            "receiptNumber" => $this->receipt_number,
            "paidAmount" => $this->paid_amount,
            "balance" => $this->balance,
            "invoiceId" => $this->invoice_id,
            "invoice" => new InvoiceResource($this->whenLoaded("invoice"))
        ];
    }
}
