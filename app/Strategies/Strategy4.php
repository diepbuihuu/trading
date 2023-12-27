<?php

namespace App\Strategies;
use Database\Factories\PriceFactory;
use App\Indicators\CandleCount;
use App\Indicators\RSI;
use App\Helpers\Math;
use App\Patterns\OverSold;
use App\Patterns\TrendStarted;
use App\Patterns\ApproachSma;
use App\Patterns\StableBand;


class Strategy4 extends SellMiddle {

    public function __construct() {
        parent::__construct();
    }

    public function getSellCondition() {

        $result = $this->trendStarted() && $this->hasOverSold() && $this->hasMoreLowCandles() && $this->firstMeetSma();

        return $result;
    }

    public function trendStarted() {
        return TrendStarted::down();
    }

    public function hasMoreLowCandles() {
        $down = CandleCount::countDown(25);
        $up = CandleCount::countUp(25);
        return $down >= $up * 2;
    }

    public function hasOverSold() {
        return OverSold::hasOverSold(15,1);
    }


    public function firstMeetSma() {
        return CandleCount::countDown(3, 2) === 3;
    }
}
