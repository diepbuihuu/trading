<?php

namespace App\Strategies;
use Database\Factories\PriceFactory;
use App\Indicators\RSI;
use App\Indicators\CandleCount;
use App\Helpers\Math;
use App\Patterns\OverSold;
use App\Patterns\TrendStarted;
use App\Patterns\ApproachSma;
use App\Patterns\StableBand;


class Strategy5 extends BuyMiddle {

    public function __construct() {
        parent::__construct();
    }

    public function getBuyCondition() {

        return $this->trendStarted() && $this->hasOverBought() && $this->hasMoreUpCandles() && $this->firstMeetSma();
    }

    public function trendStarted() {
        return TrendStarted::up();
    }

    public function hasOverBought() {
        return OverSold::hasOverBought(15,1);
    }


    public function firstMeetSma() {
        return CandleCount::countUp(3, 2) === 3;
    }

    public function hasMoreUpCandles() {
        $down = CandleCount::countDown(25);
        $up = CandleCount::countUp(25);
        return $up >= $down * 2;
    }
}
