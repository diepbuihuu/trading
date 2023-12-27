<?php

namespace App\Strategies;
use Database\Factories\PriceFactory;
use App\Indicators\RSI;
use App\Helpers\Math;
use App\Patterns\OverSold;
use App\Patterns\Cross5;


class Strategy8 extends SellTop {

    public function __construct() {
        parent::__construct();
    }

    public function getSellCondition() {

        return $this->hasOverSold() && $this->slowUp();
    }

    public function hasOverSold() {
        return OverSold::hasOverSold(20,3);
    }

    public function slowUp() {
        return !Cross5::stopSell(10);
    }

}
