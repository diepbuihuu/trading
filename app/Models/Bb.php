<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bb extends Model
{
    use HasFactory;

    protected $table = 'bb';

    protected $fillable = [
        'time',
        'sma',
        'sd',
        'upper',
        'lower'
    ];

    public static function getPastData($startTime, $limit) {

        $bbs = self::where('time', '<', $startTime)->orderBy('time', 'desc')->take($limit)->get()->toArray();
        $bbData = array_map(function($p) {
            return [$p['time'], $p['sma'], $p['sd'], $p['upper'], $p['lower']];
        }, $bbs);

        return array_reverse($bbData);
    }

    public static function getFutureData($startTime, $limit) {

        $bbs = self::where('time', '>=', $startTime)->take($limit)->get()->toArray();
        $bbData = array_map(function($p) {
            return [$p['time'], $p['sma'], $p['sd'], $p['upper'], $p['lower']];
        }, $bbs);

        return $bbData;
    }
}
