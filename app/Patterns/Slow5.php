<?php

namespace App\Patterns;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;
use App\Helpers\CandlePosition;
use App\Indicators\CandleCount;

class Slow5 {
    public static function up() {
        $lastData = PriceFactory::getLast100();
        $count = count($lastData);

        $green = 1;

        for ($i = 0; $i < 4; $i++) {

            if (CandlePosition::aboveSma($lastData[$count-2-$i], 2) && $lastData[$count-2-$i]->close > $lastData[$count-2-$i]->open) {
                $green++;
            }
        }
        return $green >= 4;
    }

    public static function down() {
        $lastData = PriceFactory::getLast100();
        $count = count($lastData);

        $red = 1;

        for ($i = 0; $i < 4; $i++) {

            if (CandlePosition::belowSma($lastData[$count-2-$i], 2) && $lastData[$count-2-$i]->close < $lastData[$count-2-$i]->open) {
                $red++;
            }
        }
        return $red >= 4;
    }
}
