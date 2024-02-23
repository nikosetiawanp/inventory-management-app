<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInventoryItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();
        if ($method == 'PUT') {
            return [
                "quantity" => ["required"],
                "inventoryId" => ["required"],
                "productId" => ["required"],
            ];
        } else {
            return [
                "quantity" => ["sometimes"],
                "inventoryId" => ["sometimes"],
                "productId" => ["sometimes"],
            ];
        }
    }
    protected function prepareForValidation()
    {
        $this->merge([
            "inventory_id" => $this->inventoryId,
            "product_id" => $this->productId,
        ]);
    }
}
