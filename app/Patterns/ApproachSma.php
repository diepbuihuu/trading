<?php

namespace App\Patterns;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;
use App\Helpers\CandlePosition;

class ApproachSma {
    public static function down($range = 1, $min = 1) {
        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        $approachCount = 0;
        for ($i = 0; $i < $range; $i++) {
            $candle = $last100[$count - 2 - $i];
            if (CandlePosition::closeToSma($candle)) {
                $approachCount++;
            }
        }
        return ($approachCount >= $min);
    }

    public static function up($range = 1, $min = 1) {
        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        $approachCount = 0;
        for ($i = 0; $i < $range; $i++) {
            $candle = $last100[$count - 2 - $i];
            if (CandlePosition::closeToSma($candle, 'above')) {
                $approachCount++;
            }
        }
        return ($approachCount >= $min);
    }
}
