<?php

namespace App\Patterns;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;
use App\Helpers\CandlePosition;

class StableBand {
    public static function stableUpper($range = 7, $threshold = 0.2) {
        $lastData = PriceFactory::getLast100();
        $count = count($lastData);

        $uppers = [];
        $uppers2 = [];

        for ($i = 0; $i < $range * 2; $i++) {
            if ($i < $range) {
                $uppers[] = $lastData[$count - 2 - $i]->upper;
            } else {
                $uppers2[] = $lastData[$count - 2 - $i]->upper;
            }
        }
        return Math::sd($uppers) <= $threshold &&  Math::sd($uppers) < Math::sd($uppers2);
    }

    public static function stableLower($range = 7, $threshold = 0.2) {
        $lastData = PriceFactory::getLast100();
        $count = count($lastData);

        $lowers = [];
        $lowers2 = [];

        for ($i = 0; $i < $range * 2; $i++) {
            if ($i < $range) {
                $lowers[] = $lastData[$count - 2 - $i]->lower;
            } else {
                $lowers2[] = $lastData[$count - 2 - $i]->lower;
            }
        }
        return Math::sd($lowers) <= $threshold &&  Math::sd($lowers) < Math::sd($lowers2);
    }

    public static function averageSd() {
        $lastData = PriceFactory::getLast100();
        $count = count($lastData);

        return ($lastData[$count - 2]->sd < 1 && $lastData[$count - 2]->sd > 0.4);
    }
}
