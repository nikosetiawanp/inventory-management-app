<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreTransactionRequest extends FormRequest
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
            "number" => ["required"],
            "type" => ["required", Rule::in(['P', 'S'])],
            "date" => ["required", "date_format:Y-m-d"],
            "expectedArrival" => ["nullable", "date_format:Y-m-d"],
            "isApproved" => ["required"],
            "isDone" => ["required"],
            "contactId" => ["required"],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "expected_arrival" => $this->expectedArrival,
            "is_approved" => $this->isApproved,
            "is_done" => $this->isDone,
            "contact_id" => $this->contactId
        ]);
    }
}
