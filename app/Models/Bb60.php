<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bb60 extends Bb
{
    use HasFactory;

    protected $table = 'bb60';

    protected $fillable = [
        'time',
        'sma',
        'sd',
        'upper',
        'lower'
    ];
}
