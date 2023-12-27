<?php

namespace App\Patterns;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;
use App\Helpers\CandlePosition;

class TrendConfirmed {
    public static function up($range = 10, $threshold = 0.2) {
        return  PriceFactory::getSmaChange(-2 - $range * 1, -2 - $range * 0) > $threshold &&
                PriceFactory::getSmaChange(-2 - $range * 2, -2 - $range * 1) > $threshold &&
                PriceFactory::getSmaChange(-2 - $range * 3, -2 - $range * 2) > $threshold;
    }

    public static function down($range = 10, $threshold = 0.2) {
        return  PriceFactory::getSmaChange(-2 - $range * 1, -2 - $range * 0) < -1 * $threshold &&
                PriceFactory::getSmaChange(-2 - $range * 2, -2 - $range * 1) < -1 * $threshold &&
                PriceFactory::getSmaChange(-2 - $range * 3, -2 - $range * 2) < -1 * $threshold;
    }
}
