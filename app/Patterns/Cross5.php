<?php

namespace App\Patterns;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;
use App\Helpers\CandlePosition;

class Cross5 {
    public static function down($range = 1) {
        $lastData = PriceFactory::getLast100();
        $count = count($lastData);

        if ($count < $range + 17) {
            return false;
        }

        for ($i = 0; $i < $range; $i++) {
            $condition1 = $lastData[$count - 2 - $i]->close < $lastData[$count - 3 - $i]->lower;
            $condition2 = false;
            $highIndex = 0;
            for ($j = 0; $j < 5; $j++) {
                if (CandlePosition::crossUpper($lastData[$count-2-$i-$j])) {
                    $condition2 = true;
                    $highIndex = $i + $j;
                    break;
                }
            }

            $result = $condition1 && $condition2;

            for ($i = 0; $i < 10; $i++) {
                $candle = $lastData[$count - 2 - $highIndex - $i];
                $result = $result && CandlePosition::aboveSma($candle);
            }

            if ($result) {
                return true;
            }
        }
        return false;
    }

    public static function up($range = 1) {
        $lastData = PriceFactory::getLast100();
        $count = count($lastData);

        if ($count < $range + 17) {
            return false;
        }

        for ($i = 0; $i < $range; $i++) {
            $condition1 = $lastData[$count - 2 - $i]->close > $lastData[$count - 3 - $i]->upper;
            $condition2 = false;
            $highIndex = 0;
            for ($j = 0; $j < 5; $j++) {
                if (CandlePosition::crossLower($lastData[$count-2-$i-$j])) {
                    $condition2 = true;
                    $highIndex = $i + $j;
                    break;
                }
            }

            $result = $condition1 && $condition2;

            for ($i = 0; $i < 10; $i++) {
                $candle = $lastData[$count - 2 - $highIndex - $i];
                $result = $result && CandlePosition::belowSma($candle);
            }

            if ($result) {
                return true;
            }
        }
        return false;
    }

    public function stopBuy($range) {
        $lastData = PriceFactory::getLast100();
        $count = count($lastData);

        for ($i = 0; $i < $range; $i++) {
            $condition1 = $i == 0 || ($lastData[$count - 1 - $i]->close < $lastData[$count - 2 - $i]->lower);
            $condition2 = false;
            for ($j = 0; $j < 5; $j++) {
                if (CandlePosition::crossUpper($lastData[$count-2-$i-$j])) {
                    $condition2 = true;
                }
            }

            $result = $condition1 && $condition2;

            if ($result) {
                return true;
            }
        }
        return false;
    }

    public function stopSell($range) {
        $lastData = PriceFactory::getLast100();
        $count = count($lastData);

        for ($i = 0; $i < $range; $i++) {
            $condition1 = $i == 0 || ($lastData[$count - 1 - $i]->close > $lastData[$count - 2 - $i]->upper);
            $condition2 = false;
            $highIndex = 0;
            for ($j = 0; $j < 5; $j++) {
                if (CandlePosition::crossLower($lastData[$count-2-$i-$j])) {
                    $condition2 = true;
                    $highIndex = $i + $j;
                }
            }

            $result = $condition1 && $condition2;
            if ($result) {
                return true;
            }
        }
        return false;
    }
}
