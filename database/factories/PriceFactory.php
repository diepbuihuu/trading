<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use App\Models\Price;

class PriceFactory extends Factory
{
    const DATA_LENGTH = 20;

    protected static $startTime = 0;

    protected static $bufferData = [];

    protected static $lastData = [];

    protected static $last100 = [];


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }

    protected static function read() {
        self::$bufferData = DB::table('prices')
                            ->join('bb', 'prices.time', '=', 'bb.time')
                            ->select('prices.*', 'bb.*')
                            ->where('prices.time', '>', self::$startTime)
                            ->orderBy('prices.time')->take(100)->get()->toArray();
    }

    public static function setStartTime($startTime) {
        self::$startTime = $startTime;
    }

    public static function shift() {
        if (count(self::$bufferData) === 0) {
            self::read();
        }

        $first = array_shift(self::$bufferData);
        self::$startTime = $first->time;

        self::$lastData[] = $first;
        self::$last100[] = $first;
        if (count(self::$lastData) > self::DATA_LENGTH) {
            array_shift(self::$lastData);
        }
        if (count(self::$last100) > 100) {
            array_shift(self::$last100);
        }

        while (count(self::$lastData) < self::DATA_LENGTH) {
            $first = array_shift(self::$bufferData);
            self::$lastData[] = $first;
            self::$last100[] = $first;
        }

        return self::$lastData;
    }

    public static function getLatest() {
        return self::$lastData;
    }

    public static function getLast100() {
        return self::$last100;
    }

    public static function getSmaChange($start, $end) {
        $count = count(self::$last100);
        if ($start > 0 || $end > 0 || $start < -1 * $count || $end < -1 * $count) {
            return 0;
        }
        return round(self::$last100[$count + $end]->sma - self::$last100[$count + $start]->sma, 2);
    }

    public function logSmaChange($points, $timezone = 'us') {
        $count = count(self::$last100);
        if ($timezone == 'us' && !in_array(date('G', self::$last100[$count - 1]->time), [19, 20, 21, 22, 23])) {
            return false;
        }

        echo date('Y-m-d H:i:s', self::$last100[$count - 1]->time) . ' ';

        for($i = 0; $i <= count($points) - 2; $i++) {
            echo self::getSmaChange($points[$i], $points[$i + 1]) . ' ';
        }
    }

}
