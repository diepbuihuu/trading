<?php

namespace App\Strategies;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;

class Strategy18 extends Strategy8 {

    protected $bb;
    protected $strongSell = false;

    public function __construct() {
        parent::__construct();
    }

    public function getSellCondition() {
        return  $this->isDownTrend() && $this->hasDownPattern() && !$this->hasReversePattern();
    }

    public function isDownTrend() {
        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        if ($last100[$count - 22]->sma - $last100[$count - 2]->sma > $last100[$count - 2]->sd * 2) {
            $this->strongSell = true;
            return true;
        } else {
            $this->strongSell = false;
        }

        if ($last100[$count - 22]->sma - $last100[$count - 2]->sma > 0.4 && $last100[$count - 2]->sd < 0.75) {
            return true;
        }
        return false;
    }

    public function hasReversePattern() {
        $lastData = $this->bb->getLastData();
        $count = count($lastData);

        for ($i = 0; $i < 10; $i++) {
            if ($lastData[$count-2-$i]->low < $lastData[$count-2-$i]->lower) {
                return false;
            }
        }
        return true;
    }


    public function hasDownPattern() {
        $lastData = $this->bb->getLastData();
        $count = count($lastData);

        $red = 0;
        $green = 0;

        $lastPrice = $lastData[$count-1];

        if ($lastData[$count-2]->sma - $lastPrice->open > 0) {
            $green++;
        }

        for ($i = 0; $i < 4; $i++) {
            if ($lastData[$count-2-$i]->close > $lastData[$count-2-$i]->sma || $lastData[$count-2-$i]->open > $lastData[$count-2-$i]->sma) {
                return false;
            }
            if ($lastData[$count-2-$i]->low < $lastData[$count-2-$i]->lower) {
                return false;
            }

            if ($lastData[$count-2-$i]->close > $lastData[$count-2-$i]->open) {
                $green++;
            } else {
                $red++;
            }
        }

        return ($green >= 4 || $red >= 4) && ($this->strongSell || $this->hasBreakPattern());
    }

    public function hasBreakPattern() {
        $lastData = $this->bb->getLastData();
        $count = count($lastData);

        $breakCount = 0;
        for ($i = 0; $i < 15; $i++) {
            if ($lastData[$count-2-$i]->close > $lastData[$count-2-$i]->upper) {
                $breakCount++;
            }

            if ($breakCount >= 3) {
                return true;
            }

            if ($lastData[$count-2-$i]->close < $lastData[$count-2-$i]->sma && $lastData[$count-2-$i]->open < $lastData[$count-2-$i]->sma) {
                return false;
            }
        }

        return false;
    }

    public function shouldChangeStopLoss() {
        return false;
    }

    public function shouldChangeTakeProfit() {
        return false;
    }

    public function shouldCloseOrder() {

        return false;
    }

}
