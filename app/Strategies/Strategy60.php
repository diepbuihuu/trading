<?php

namespace App\Strategies;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;
use App\Patterns\Cross5;

class Strategy60 extends Strategy6 {

    protected $bb;
    protected $stableThreshold = 0.5;

    public function __construct() {
        parent::__construct();
    }

    public function getSellCondition() {
        return  $this->hasDownPattern();
    }

    public function hasDownPattern() {
        return Cross5::down();
    }

}
