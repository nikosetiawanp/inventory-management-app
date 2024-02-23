<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DebtPaymentResource extends JsonResource
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
            "receiptNumber" => $this->receipt_number,
            "paidDate" => $this->paid_date,
            "paidAmount" => $this->paid_amount,
            "balance" => $this->balance,
            "debtId" => $this->debt_id,
            "debt" => new DebtResource($this->whenLoaded("debt"))
        ];
    }
}
