<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        "date",
        "amount",
        "debt_id",
        "contact_id"
    ];

    public function debt(): BelongsTo
    {
        return $this->belongsTo(Debt::class);
    }
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
