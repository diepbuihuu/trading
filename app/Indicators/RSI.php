<?php

namespace App\Indicators;
use Database\Factories\PriceFactory;
use App\Helpers\Math;

class RSI {

    public static function calculate($period, $nextPrice) {
        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        if ($count < $period + 2) {
            return 50;
        }

        $red = $green = 0.01;

        if ($nextPrice > $last100[$count - 1]->open) {
            $green += ($nextPrice - $last100[$count - 1]->open);
        } else {
            $red +=  $last100[$count - 1]->open - $nextPrice;
        }

        for ($i = 0; $i < $period - 1; $i++) {
            $candle = $last100[$count - 2 - $i];
            if ($candle->close > $candle->open) {
                $green += $candle->close - $candle->open;
            } else {
                $red += $candle->open - $candle->close;
            }
        }

        return intval(100 - 100 / (1 + $green / $red));
    }
}
