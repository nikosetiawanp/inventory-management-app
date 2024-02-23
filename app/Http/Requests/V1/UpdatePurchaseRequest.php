<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdatePurchaseRequest extends FormRequest
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
                "expectedArrival" => ["nullable", "date_format:format:Y-m-d"],
                "isApproved" => ["required"],
                "contactId" => ["required"],
            ];
        } else {
            return [
                "number" => ["sometimes"],
                "date" => ["sometimes", "date_format:Y-m-d"],
                "expectedArrival" => ["nullable", "date_format:format:Y-m-d"],
                "isApproved" => ["sometimes"],
                "contactId" => ["sometimes"],
            ];
        }
    }
    protected function prepareForValidation()
    {
        $this->merge([
            "expected_arrival" => $this->expectedArrival,
            "is_approved" => $this->isApproved,
            "contact_id" => $this->contactId
        ]);
    }
}
