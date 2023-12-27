<?php

namespace App\Strategies;
use Database\Factories\PriceFactory;
use App\Helpers\CandlePosition;
use App\Patterns\Cross3;
use App\Patterns\Cross5;

class Strategy7 extends BuyDelay {

    protected $expectGain = 3;

    public function __construct() {
        parent::__construct();
    }

    public function getBuyCondition() {
        return  $this->hasUpPattern();
    }

    public function getBuyCondition2() {
        $lastData = PriceFactory::getLast100();
        $count = count($lastData);
        return CandlePosition::crossSma($lastData[$count - 2]);
    }

    public function hasUpPattern() {
        return Cross3::up() || Cross5::up();
    }
}
