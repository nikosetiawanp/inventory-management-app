<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDebtRequest extends FormRequest
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
                "debtAmount" => ["required"],
                "status" => ["required"],
                "paidDate" => ["nullable", "date_format:Y-m-d"],
                "receiptNumber" => ["nullable"],
                "paidAmount" => ["nullable"],
                "balance" => ["required"],
                "invoiceId" => ["required"],
            ];
        } else {
            return [
                "debtAmount" => ["sometimes", "required"],
                "status" => ["sometimes", "required"],
                "paidDate" => ["nullable", "date_format:Y-m-d"],
                "receiptNumber" => ["nullable"],
                "paidAmount" => ["nullable"],
                "balance" => ["sometimes", "required"],
                "invoiceId" => ["sometimes", "required"],
            ];
        }
    }
}
