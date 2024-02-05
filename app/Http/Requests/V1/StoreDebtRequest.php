<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreDebtRequest extends FormRequest
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
            "debtAmount" => ["required"],
            "status" => ["required"],
            "balance" => ["required"],
            "paidDate" => ["nullable", "date_format:Y-m-d"],
            "receiptNumber" => ["nullable"],
            "paidAmount" => ["nullable"],
            "invoiceId" => ["required"],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "debt_amount" => $this->debtAmount,
            "paid_date" => $this->paidDate,
            "receipt_number" => $this->receiptNumber,
            "paid_amount" => $this->paidAmount,
            "invoice_id" => $this->invoiceId
        ]);
    }
}
