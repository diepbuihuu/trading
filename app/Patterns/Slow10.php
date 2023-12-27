<?php

namespace App\Patterns;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;
use App\Helpers\CandlePosition;
use App\Indicators\CandleCount;

class Slow10 {
    public static function up() {
        return CandleCount::countUp(10, 2) === 10;
    }

    public static function down() {
        return CandleCount::countDown(10, 2) === 10;
    }
}
