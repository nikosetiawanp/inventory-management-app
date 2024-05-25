<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDebtRequest extends FormRequest
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
            "amount" => ["required"],
            "type" => ["required", Rule::in(['D', 'R'])],
            "isPaid" => ["required"],
            "invoiceId" => ["required"],
            "contactId" => ["required"]
        ];
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
