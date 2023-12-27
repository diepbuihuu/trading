<?php

namespace App\Patterns;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;
use App\Helpers\CandlePosition;

class Cross3 {
    public static function down() {
        $lastData = PriceFactory::getLast100();
        $count = count($lastData);

        $result  = (
                        CandlePosition::belowSma($lastData[$count - 2]) &&
                        CandlePosition::belowSma($lastData[$count - 3]) &&
                        CandlePosition::belowSma($lastData[$count - 4]) &&
                        $lastData[$count - 5]->close <  $lastData[$count - 5]->sma &&
                        (
                            CandlePosition::crossUpper($lastData[$count - 5]) ||
                            CandlePosition::crossUpper($lastData[$count - 6]) ||
                            CandlePosition::crossUpper($lastData[$count - 7])
                        )

                  );

          for ($i = 8; $i < 18; $i++) {
              $result = $result && CandlePosition::aboveSma($lastData[$count - $i]);
          }

          return $result;
    }

    public static function up() {
        $lastData = PriceFactory::getLast100();
        $count = count($lastData);
        $result = (
                        CandlePosition::aboveSma($lastData[$count - 2]) &&
                        CandlePosition::aboveSma($lastData[$count - 3]) &&
                        CandlePosition::aboveSma($lastData[$count - 4]) &&
                        $lastData[$count - 5]->close > $lastData[$count - 5]->sma &&
                        (
                            CandlePosition::crossLower($lastData[$count - 5]) ||
                            CandlePosition::crossLower($lastData[$count - 6]) ||
                            CandlePosition::crossLower($lastData[$count - 7])
                        )
                  );

        for ($i = 8; $i < 18; $i++) {
          $result = $result && CandlePosition::belowSma($lastData[$count - $i]);
        }

        return $result;
    }

    public function stopBuy($range) {
        $lastData = PriceFactory::getLast100();
        $count = count($lastData);

        for ($i = 0; $i < $range; $i++) {
            $condition1 = ($i == 0) || ($lastData[$count - 1 - $i]->close < $lastData[$count - 1 - $i]->lower);
            $condition2 = false;
            for ($j = 0; $j < 3; $j++) {
                if ($lastData[$count-1-$i-$j]->open > $lastData[$count-1-$i-$j]->sma) {
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
            $condition1 = $i == 0 || ($lastData[$count - 1 - $i]->close > $lastData[$count - 1 - $i]->upper);
            $condition2 = false;
            for ($j = 0; $j < 3; $j++) {
                if ($lastData[$count-1-$i-$j]->open < $lastData[$count-1-$i-$j]->sma) {
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
}
