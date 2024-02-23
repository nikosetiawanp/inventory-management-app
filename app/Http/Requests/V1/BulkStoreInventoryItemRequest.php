<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class BulkStoreInventoryItemRequest extends FormRequest
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
            "*.stockAfter" => ["required", "numeric"],
            "*.inventoryId" => ["required"],
            "*.productId" => ["required"],
        ];
    }

    protected function prepareForValidation()
    {
        $data = [];
        foreach ($this->toArray() as $obj) {
            $obj["inventory_id"] = $obj["inventoryId"] ?? null;
            $obj["product_id"] = $obj["productId"] ?? null;

            $data[] = $obj;
        }

        $this->merge($data);
    }
}
