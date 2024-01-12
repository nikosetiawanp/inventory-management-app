<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "code",
        "name",
        "unit",
        "quantity"
    ];
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function inventoryHistories()
    {
        return $this->hasMany(InventoryHistory::class);
    }
}
