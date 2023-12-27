<?php

namespace App\Strategies;
use Database\Factories\PriceFactory;
use App\Indicators\RSI;
use App\Helpers\Math;
use App\Patterns\OverSold;
use App\Patterns\Cross5;
use App\Patterns\Cross3;


class Strategy9 extends BuyBottom {

    public function __construct() {
        parent::__construct();
    }

    public function getBuyCondition() {

        return $this->hasOverBought() && $this->slowDown();
    }

    public function hasOverBought() {
        return OverSold::hasOverBought(20,3);
    }

    public function slowDown() {
        return !Cross5::stopBuy(10);
    }

}
