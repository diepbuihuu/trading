<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;
    protected $fillable = [
        'time',
        'high',
        'low',
        'open',
        'close'
    ];

    public static function getPastData($startTime, $limit) {
        $prices = self::where('time', '<', $startTime)->orderBy('time', 'desc')->take($limit)->get()->toArray();
        $candles = array_map(function($p) {
            return [$p['time'], $p['open'], $p['high'], $p['low'], $p['close']];
        }, $prices);
        return array_reverse($candles);
    }

    public static function getFutureData($startTime, $limit) {
        $prices = self::where('time', '>=', $startTime)->take($limit)->get()->toArray();
        $candles = array_map(function($p) {
            return [$p['time'], $p['open'], $p['high'], $p['low'], $p['close']];
        }, $prices);
        return $candles;
    }
}
