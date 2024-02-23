<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
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
                "dueDate" => ["required", "date_format:Y-m-d"],
                "purchaseId" => ["required"],
                "inventoryId" => ["required"]
            ];
        } else {
            return [
                "number" => ["sometimes"],
                "date" => ["sometimes", "date_format:Y-m-d"],
                "dueDate" => ["sometimes", "date_format:Y-m-d"],
                "purchaseId" => ["sometimes"],
                "inventoryId" => ["sometimes"]
            ];
        }
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "due_date" => $this->dueDate,
            "purchase_id" => $this->purchaseId,
            "inventory_id" => $this->inventoryId
        ]);
    }
}
