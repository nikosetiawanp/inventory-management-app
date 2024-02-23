<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DebtPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        "status",
        "paid_date",
        "receipt_number",
        "paid_amount",
        "balance",
        "debt_id"
    ];

    public function debt(): BelongsTo
    {
        return $this->belongsTo(Debt::class);
    }
}
