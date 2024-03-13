<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cash extends Model
{
    use HasFactory;

    protected $fillable = [
        "date",
        "number",
        "description",
        "amount",
        "account_id"
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
