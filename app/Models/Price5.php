<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price5 extends Price
{
    use HasFactory;
    protected $fillable = [
        'time',
        'high',
        'low',
        'open',
        'close'
    ];
}
