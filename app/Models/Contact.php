<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
