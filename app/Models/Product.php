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
        "unit"
    ];
    public function item()
    {
        return $this->hasMany(Item::class);
    }
}
