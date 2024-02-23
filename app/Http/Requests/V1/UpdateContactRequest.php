<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
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
        if ($method == 'PUT') {
            return [
                "code" => ["required"],
                "name" => ["required"],
                "email" => ["nullable", "email"],
                "phone" => ["nullable"],
                "province" => ["nullable"],
                "city" => ["nullable"],
                "address" => ["nullable"],
                "isSupplier" => ["required"]
            ];
        } else {
            return [
                "code" => ["sometimes"],
                "name" => ["sometimes"],
                "email" => ["nullable", "email"],
                "phone" => ["nullable"],
                "province" => ["nullable"],
                "city" => ["nullable"],
                "address" => ["nullable"],
                "isSupplier" => ["sometimes"]
            ];
        }
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "is_supplier" => $this->isSupplier,
        ]);
    }
}
