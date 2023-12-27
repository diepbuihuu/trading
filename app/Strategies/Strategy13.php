<?php

namespace App\Strategies;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;

class Strategy13 extends Strategy11 {

    protected $bb;

    public function __construct() {
        parent::__construct();
    }

    public function hasMoreHighCandles() {

        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        $down = 0;
        $up = 0;
        $lastDown = 0;
        for ($i = 0; $i < 40; $i++) {
            $price = $last100[$count - 1 - $i];
            if ( $price->open < $price->sma && $price->close < $price->sma) {
                if ($up > 0) {
                    break;
                }
                $down++;
            } else if ($price->open > $price->sma && $price->close > $price->sma) {
                $up++;
            }
        }

        return $up >= $down * 1.5;
    }

    public function shouldCloseOrder() {
        return false;
    }
}
