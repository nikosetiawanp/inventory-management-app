<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInventoryRequest extends FormRequest
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
        $method = $this->method();
        if ($method === "PUT") {
            return [
                "number" => ["required"],
                "date" => ["required", "date_format:Y-m-d"],
                "isArrival" => ["required"],
                "receiptNumber" => ["required"],
                "description" => ["nullable"],
                "purchaseId" => ["required"],
            ];
        } else {
            return [
                "number" => ["sometimes"],
                "date" => ["sometimes", "date_format:Y-m-d"],
                "isArrival" => ["sometimes"],
                "receiptNumber" => ["sometimes"],
                "description" => ["nullable"],
                "purchaseId" => ["sometimes"],
            ];
        }
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "is_arrival" => $this->isArrival,
            "receipt_number" => $this->receiptNumber,
            "purchase_id" => $this->purchaseId,
        ]);
    }
}
