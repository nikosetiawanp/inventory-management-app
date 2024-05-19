<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "number" => ["required"],
            "date" => ["required", "date_format:Y-m-d"],
            "dueDate" => ["required", "date_format:Y-m-d"],
            "transactionId" => ["required"],
            "inventoryId" => ["required"]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "due_date" => $this->dueDate,
            "transaction_id" => $this->transactionId,
            "inventory_id" => $this->inventoryId
        ]);
    }
}
