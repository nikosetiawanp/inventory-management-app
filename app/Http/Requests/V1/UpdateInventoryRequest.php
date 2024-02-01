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
                "date" => ["required", "date_format:Y-m-d"],
                "letterNumber" => ["required"],
                "type" => ["required", Rule::in(['A', 'D'])],
                "description" => ["nullable"],
                "purchaseId" => ["required"],
                "invoiceNumber" => ["required"],
                "dueDate" => ["required", "date_format:Y-m-d"]
            ];
        } else {
            return [
                "date" => ["sometimes", "required", "date_format:Y-m-d"],
                "letterNumber" => ["sometimes", "required"],
                "type" => ["sometimes", "required", Rule::in(['A', 'D'])],
                "description" => ["nullable"],
                "purchaseId" => ["sometimes", "required"],
                "invoiceNumber" => ["sometimes"],
                "dueDate" => ["sometimes", "date_format:Y-m-d"]
            ];
        }
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "letter_number" => $this->letterNumber,
            "purchase_id" => $this->purchaseId,
            "invoice_number" => $this->invoiceNumber,
        ]);
    }
}
