<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCashRequest extends FormRequest
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
                "date" => ["required"],
                "number" => ["required"],
                "description" => ["nullable"],
                "amount" => ["required"],
                "accountId" => ["required"]
            ];
        } else {
            return [
                "date" => ["sometimes"],
                "number" => ["sometimes"],
                "description" => ["nullable"],
                "amount" => ["sometimes"],
                "accountId" => ["sometimes"]
            ];
        }
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "account_id" => $this->accountId,
        ]);
    }
}
