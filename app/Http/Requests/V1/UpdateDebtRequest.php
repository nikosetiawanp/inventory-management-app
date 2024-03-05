<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDebtRequest extends FormRequest
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
                "amount" => ["required"],
                "isPaid" => ["required"],
                "invoiceId" => ["required"],
                "contactId" => ["required"]
            ];
        } else {
            return [
                "amount" => ["sometimes"],
                "isPaid" => ["sometimes"],
                "invoiceId" => ["sometimes"],
                "contactId" => ["sometimes"]
            ];
        }
    }
    protected function prepareForValidation()
    {
        $this->merge([
            "is_paid" => $this->isPaid,
            "invoice_id" => $this->invoiceId,
            "contact_id" => $this->contactId
        ]);
    }
}
