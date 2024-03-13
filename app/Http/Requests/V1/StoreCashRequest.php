<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreCashRequest extends FormRequest
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
            "number" => ["required"],
            "description" => ["nullable"],
            "amount" => ["required"],
            "accountId" => ["required"]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "account_id" => $this->accountId,
        ]);
    }
}
