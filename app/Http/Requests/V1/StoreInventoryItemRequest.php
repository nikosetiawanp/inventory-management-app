<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryItemRequest extends FormRequest
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
            "quantity" => ["required"],
            "stockAfter" => ["sometimes"],
            "inventoryId" => ["required"],
            "productId" => ["required"],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "stock_after" => $this->stockAfter,
            "inventory_id" => $this->inventoryId,
            "product_id" => $this->productId,
        ]);
    }
}
