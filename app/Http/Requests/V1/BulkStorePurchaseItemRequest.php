<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class BulkStorePurchaseItemRequest extends FormRequest
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
            "*.quantity" => ["required", "integer"],
            "*.price" => ["required", "numeric"],
            "*.discount" => ["required", "numeric"],
            "*.tax" => ["required", "numeric"],
            "*.purchaseId" => ["required"],
            "*.productId" => ["required"],
        ];
    }

    protected function prepareForValidation()
    {
        $data = [];
        foreach ($this->toArray() as $obj) {
            $obj["purchase_id"] = $obj["purchaseId"] ?? null;
            $obj["product_id"] = $obj["productId"] ?? null;

            $data[] = $obj;
        }

        $this->merge($data);
    }
}
