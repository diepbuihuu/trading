<?php

namespace App\Strategies;
use App\Models\Order;
use App\Helpers\Math;
use App\Indicators\CandleCount;
use App\Patterns\TrendConfirmed;
use App\Patterns\StableBand;
use App\Patterns\Slow10;

class Strategy3 extends BuyMiddle {

    protected $stableThreshold = 0.2;

    public function __construct() {
        parent::__construct();
    }

    public function getBuyCondition() {
        return  $this->trendConfirmed() && $this->isStable() && $this->firstMeetSma() && !$this->hasRevertPattern();
    }

    public function trendConfirmed() {
        return TrendConfirmed::up();
    }


    public function isStable() {
        return StableBand::averageSd();
    }

    public function firstMeetSma() {
        return CandleCount::countUp(3, 2) === 3;
    }

    public function hasRevertPattern() {
        return Slow10::up();
    }
}
