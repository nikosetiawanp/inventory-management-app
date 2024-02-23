<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseItemRequest extends FormRequest
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
            "price" => ["required"],
            "discount" => ["required"],
            "tax" => ["required"],
            "purchaseId" => ["required"],
            "productId" => ["required"],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "purchase_id" => $this->purchaseId,
            "product_id" => $this->productId,
        ]);
    }
}
