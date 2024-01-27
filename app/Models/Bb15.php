<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bb15 extends Bb
{
    use HasFactory;

    protected $table = 'bb15';

    protected $fillable = [
        'time',
        'sma',
        'sd',
        'upper',
        'lower'
    ];
}
