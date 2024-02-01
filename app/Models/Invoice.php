<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        "invoice_number",
        "date",
        "due_date",
        "total_debt",
        "purchase_id",
        "inventory_id"
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }
}
