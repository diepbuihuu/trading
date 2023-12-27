<?php

namespace App\Patterns;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;
use App\Helpers\CandlePosition;

class OverSold {
    public static function hasOverSold($range = 15, $minBreak = 4) {
        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        $breakCount = 0;
        for ($i = 0; $i < $range; $i++) {
            $candle = $last100[$count - 2 - $i];
            if (CandlePosition::breakLower($candle)) {
                $breakCount++;
            }
        }
        return ($breakCount >= $minBreak);
    }

    public static function hasOverBought($range = 15, $minBreak = 4) {
        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        $breakCount = 0;
        for ($i = 0; $i < $range; $i++) {
            $candle = $last100[$count - 2 - $i];
            if (CandlePosition::breakUpper($candle)) {
                $breakCount++;
            }
        }
        return ($breakCount >= $minBreak);
    }

    public static function hasLowerCandles($range = 15, $minBreak = 4) {
        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        $breakCount = 0;
        for ($i = 0; $i < $range; $i++) {
            $candle = $last100[$count - 2 - $i];
            if (CandlePosition::crossLower($candle)) {
                $breakCount++;
            }
        }
        return ($breakCount >= $minBreak);
    }

    public static function hasUpperCandles($range = 15, $minBreak = 4) {
        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        $breakCount = 0;
        for ($i = 0; $i < $range; $i++) {
            $candle = $last100[$count - 2 - $i];
            if (CandlePosition::breakUpper($candle)) {
                $breakCount++;
            }
        }
        return ($breakCount >= $minBreak);
    }
}
