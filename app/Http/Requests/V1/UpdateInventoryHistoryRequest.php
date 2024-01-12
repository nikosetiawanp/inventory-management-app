<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInventoryHistoryRequest extends FormRequest
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
                "type" => ["required", Rule::in(['A', 'D'])],
                "description" => ["nullable"],
                "quantity" => ["required"],
                "stockAfter" => ["required"],

                "productId" => ["required"],
                "purchaseId" => ["nullable"],
            ];
        } else {
            return [
                "date" => ["sometimes", "required", "date_format:Y-m-d"],
                "type" => ["required", Rule::in(['A', 'D'])],
                "description" => ["sometimes", "nullable"],
                "quantity" => ["sometimes", "required"],
                "stockAfter" => ["sometimes", "required"],

                "productId" => ["required"],
                "purchaseId" => ["nullable"],
            ];
        }
    }
}
