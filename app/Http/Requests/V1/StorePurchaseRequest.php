<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePurchaseRequest extends FormRequest
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
            "vendorId" => ["required"],
            "prNumber" => ["required"],
            "status" => ["required",  Rule::in(['PR', 'PO'])],
            "prDate" => ["required", "date_format:Y-m-d"],
            "poNumber" => ["nullable"],
            "poDate" => ["nullable", "date_format:Y-m-d"],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "vendor_id" => $this->vendorId,
            "pr_number" => $this->prNumber,
            "pr_date" => $this->prDate,
            "po_number" => $this->poNumber,
            "po_date" => $this->poDate,
        ]);
    }
}
