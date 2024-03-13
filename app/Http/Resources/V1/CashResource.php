<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CashResource extends JsonResource
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
            "date" => $this->date,
            "number" => $this->number,
            "description" => $this->description,
            "amount" => $this->amount,
            "accountId" => $this->account_id,

            "account" => new AccountResource($this->whenLoaded("account")),
        ];
    }
}
