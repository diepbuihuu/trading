<?php

namespace App\Indicators;
use Database\Factories\PriceFactory;
use App\Helpers\Math;
use App\Helpers\CandlePosition;

class CandleCount {

    public static function countUp($range = 10, $strict = 0) {
        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        if ($count < $range + 2) {
            return 0;
        }

        $candleCount = 0;
        for ($i = 0; $i < $range; $i++) {
            $candle = $last100[$count - 2 - $i];
            if (CandlePosition::aboveSma($candle, $strict)) {
                $candleCount++;
            }
        }
        return $candleCount;
    }

    public static function countDown($range = 10, $strict = 0) {
        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        if ($count < $range + 2) {
            return 0;
        }

        $candleCount = 0;
        for ($i = 0; $i < $range; $i++) {
            $candle = $last100[$count - 2 - $i];
            if (CandlePosition::belowSma($candle, $strict)) {
                $candleCount++;
            }
        }
        return $candleCount;
    }

    public static function noUp($range = 10) {
        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        if ($count < $range + 2) {
            return 0;
        }

        for ($i = 0; $i < $range; $i++) {
            $candle = $last100[$count - 2 - $i];
            if (CandlePosition::aboveSma($candle) || CandlePosition::crossSma($candle)) {
                return false;
            }
        }
        return true;
    }

    public static function noDown($range = 10) {
        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        if ($count < $range + 2) {
            return 0;
        }

        for ($i = 0; $i < $range; $i++) {
            $candle = $last100[$count - 2 - $i];
            if (CandlePosition::belowSma($candle) || CandlePosition::crossSma($candle)) {
                return false;
            }
        }
        return true;
    }
}
