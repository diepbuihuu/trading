<?php

namespace App\Strategies;
use App\Models\Order;
use App\Helpers\Math;
use App\Indicators\CandleCount;
use App\Patterns\StableBand;
use App\Patterns\TrendConfirmed;
use App\Patterns\Slow10;

class Strategy2 extends SellMiddle {

    protected $stableThreshold = 0.2;

    public function __construct() {
        parent::__construct();
    }

    public function getSellCondition() {
        //$this->bb->getBandWidth() >= 1.8 && $this->bb->getBandWidth() <= 3
        return  $this->trendConfirmed() && $this->isStable() && $this->firstMeetSma() && !$this->hasRevertPattern();
    }

    public function trendConfirmed() {
        return TrendConfirmed::down();
    }

    public function isStable() {
        return StableBand::averageSd();
    }

    public function firstMeetSma() {
        return CandleCount::countDown(3, 2) === 3;
    }

    public function hasRevertPattern() {
        return Slow10::down();
    }
}
