<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateTransactionRequest extends FormRequest
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
                "type" => ["required", Rule::in(['P', 'S'])],
                "date" => ["required", "date_format:Y-m-d"],
                "expectedArrival" => ["nullable", "date_format:format:Y-m-d"],
                "isApproved" => ["required"],
                "isDone" => ["required"],
                "contactId" => ["required"],
            ];
        } else {
            return [
                "number" => ["sometimes"],
                "type" => ["sometimes", Rule::in(['P', 'S'])],
                "date" => ["sometimes", "date_format:Y-m-d"],
                "expectedArrival" => ["nullable", "date_format:format:Y-m-d"],
                "isApproved" => ["sometimes"],
                "isDone" => ["done"],
                "contactId" => ["sometimes"],
            ];
        }
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
