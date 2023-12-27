<?php

namespace App\Strategies;
use Database\Factories\PriceFactory;
use App\Helpers\CandlePosition;
use App\Patterns\Cross3;
use App\Patterns\Cross5;

class Strategy6 extends SellDelay {

    protected $expectGain = 3;

    public function __construct() {
        parent::__construct();
    }

    public function getSellCondition() {
        return  $this->hasDownPattern();
    }

    public function getSellCondition2() {
        $lastData = PriceFactory::getLast100();
        $count = count($lastData);
        return CandlePosition::crossSma($lastData[$count - 2]);
    }

    public function hasDownPattern() {
        return Cross3::down() || Cross5::down();
    }


}
