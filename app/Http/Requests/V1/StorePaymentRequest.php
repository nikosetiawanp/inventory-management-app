<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StorePaymentRequest extends FormRequest
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
            "date" => ["required"],
            "amount" => ["required"],
            "number" => ["required"],
            "debtId" => ["required"],
            "contactId" => ["required"],
            "accountId" => [Rule::in([1, 2])],
            "description" => ["required"],
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            "debt_id" => $this->debtId,
            "contact_id" => $this->contactId,
            "account_id" => $this->accountId,
        ]);
    }
}
