<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInventoryRequest extends FormRequest
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
            "date" => ["required", "date_format:Y-m-d"],
            "letterNumber" => ["required"],
            "type" => ["required", Rule::in(['A', 'D'])],
            "description" => ["nullable"],
            "purchaseId" => ["required"],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "letter_number" => $this->letterNumber,
            "purchase_id" => $this->purchaseId,
        ]);
    }
}
