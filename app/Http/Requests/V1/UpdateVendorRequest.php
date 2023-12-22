<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVendorRequest extends FormRequest
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
                "address" => ["required"],
                "email" => ["required", "email"],
                "phone" => ["required"],
            ];
        } else {
            return [
                "code" => ["sometimes", "required"],
                "name" => ["sometimes", "required"],
                "address" => ["sometimes", "required"],
                "email" => ["sometimes", "required", "email"],
                "phone" => ["sometimes", "required"],
            ];
        }
    }
}
