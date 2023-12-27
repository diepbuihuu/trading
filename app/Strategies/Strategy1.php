<?php

namespace App\Strategies;
use App\Indicators\BollingerBand;

class Strategy1 extends SellTop {
    protected $expectGain = 2;
}
