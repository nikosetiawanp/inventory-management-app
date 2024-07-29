<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        "code",
        "name",
        "email",
        "phone",
        "province",
        "city",
        "address",
        "type"
    ];
    public function debts(): HasMany
    {
        return $this->hasMany(Debt::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
