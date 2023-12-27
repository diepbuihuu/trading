<?php

namespace App\Strategies;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;
use App\Patterns\Cross5;

class Strategy61 extends Strategy7 {

    protected $bb;

    public function __construct() {
        parent::__construct();
    }

    public function getBuyCondition() {
        return  $this->hasUpPattern();
    }

    public function hasUpPattern() {
        return Cross5::up();
    }

}
