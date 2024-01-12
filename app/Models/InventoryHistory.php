<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryHistory extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        "date",
        "type",
        "description",
        "quantity",
        "stock_after",
        "product_id",
        "purchase_id"
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
