<?php

namespace App\Strategies;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;
use App\Patterns\Slow10;

class Strategy11 extends BuyNow {

    public function getBuyCondition() {
        return $this->have10SlowCandles();
    }

    public function have10SlowCandles() {
        return Slow10::down();
    }
}
