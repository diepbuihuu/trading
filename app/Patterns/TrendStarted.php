<?php

namespace App\Patterns;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;
use App\Helpers\CandlePosition;

class TrendStarted {
    public static function up($range = 7, $threshold = 0.2) {

        return  PriceFactory::getSmaChange(-2 - $range * 1, -2 - $range * 0) > 2 * $threshold &&
                PriceFactory::getSmaChange(-2 - $range * 2, -2 - $range * 1) > 0 &&
                PriceFactory::getSmaChange(-2 - $range * 3, -2 - $range * 2) > -1 * $threshold;
    }

    public static function down($range = 7, $threshold = 0.2) {

        return  PriceFactory::getSmaChange(-2 - $range * 1, -2 - $range * 0) < -2 * $threshold &&
                PriceFactory::getSmaChange(-2 - $range * 2, -2 - $range * 1) < 0 &&
                PriceFactory::getSmaChange(-2 - $range * 3, -2 - $range * 2) < $threshold;
    }
}
