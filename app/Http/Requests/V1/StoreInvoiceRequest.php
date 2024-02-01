<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            "invoiceNumber" => ["required"],
            "date" => ["required", "date_format:Y-m-d"],
            "dueDate" => ["required", "date_format:Y-m-d"],
            "totalDebt" => ["required"],
            "purchaseId" => ["required"],
            "inventoryId" => ["required"]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "invoice_number" => $this->invoiceNumber,
            "due_date" => $this->dueDate,
            "total_debt" => $this->totalDebt,
            "purchase_id" => $this->purchaseId,
            "inventory_id" => $this->inventoryId
        ]);
    }
}


// $table->string('invoice_number');
// $table->dateTime('date');
// $table->dateTime('due_date');
// $table->decimal('total_debt');
// $table->string('purchase_id');
// $table->string('inventory_id');