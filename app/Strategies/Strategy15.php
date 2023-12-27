<?php

namespace App\Strategies;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;

class Strategy15 extends Strategy11 {

    protected $bb;

    public function __construct() {
        parent::__construct();
    }

    public function isUpTrend() {

        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        if (count($last100) < 63) {
            return false;
        }

        $check1 = $last100[$count - 2]->sma - $last100[$count - 9]->sma;
        $check2 = $last100[$count - 9]->sma - $last100[$count - 16]->sma;
        $check3 = $last100[$count - 16]->sma - $last100[$count - 23]->sma;
        $check4 = $last100[$count - 2]->sma - $last100[$count - 62]->sma;

        for ($i = 0; $i < 3; $i++) {
            if ($last100[$count - 2 -$i]->sd > $last100[$count - 3 -$i]->sd) {
                return false;
            }
        }

        for ($i = 0; $i < 3; $i++) {
            if ($last100[$count - 8 -$i]->sd <= $last100[$count - 9 -$i]->sd) {
                return false;
            }
        }

        return $check1 >= 0.4 && $check2 > 0 && $check4 < 0 && $last100[$count - 2]->sd < 1;
    }

    public function shouldCloseOrder() {
        return false;
    }
}
