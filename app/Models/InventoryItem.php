<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        "quantity",
        "inventory_id",
        "product_id",
        "transaction_item_id"
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }
    public function transactionItem(): BelongsTo
    {
        return $this->belongsTo(TransactionItem::class);
    }
}
