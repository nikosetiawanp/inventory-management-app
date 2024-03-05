<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        "number",
        "date",
        "due_date",
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

    public function debts(): HasMany
    {
        return $this->hasMany(Debt::class);
    }
}
