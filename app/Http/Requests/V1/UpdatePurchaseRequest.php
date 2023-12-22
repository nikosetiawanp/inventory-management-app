<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
                "vendor_id" => ["required"],
                "prNumber" => ["required"],
                "prDate" => ["required", "date_format:Y-m-d H:i:s"],
                "poNumber" => ["nullable"],
                "poDate" => ["nullable", "date_format:Y-m-d H:i:s"],
            ];
        } else {
            return [
                "vendor_id" => ["sometimes", "required"],
                "prNumber" => ["sometimes", "required"],
                "prDate" => ["sometimes", "required", "date_format:Y-m-d H:i:s"],
                "poNumber" => ["sometimes", "nullable"],
                "poDate" => ["sometimes", "nullable", "date_format:Y-m-d H:i:s"],
            ];
        }
    }
}
