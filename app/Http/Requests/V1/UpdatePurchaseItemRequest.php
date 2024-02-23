<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseItemRequest extends FormRequest
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
                "quantity" => ["required"],
                "price" => ["required"],
                "discount" => ["required"],
                "tax" => ["required"],
                "purchaseId" => ["required"],
                "productId" => ["required"],
            ];
        } else {
            return [
                "quantity" => ["sometimes", "required"],
                "price" => ["sometimes", "required"],
                "discount" => ["sometimes", "required"],
                "tax" => ["sometimes", "required"],
                "purchaseId" => ["sometimes", "required"],
                "productId" => ["sometimes", "required"],
            ];
        }
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "purchase_id" => $this->purchaseId,
            "product_id" => $this->productId,
        ]);
    }
}
