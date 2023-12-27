<?php

namespace App\Strategies;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;

class Strategy19 extends Strategy9 {

    protected $bb;
    protected $strongBuy = false;

    public function __construct() {
        parent::__construct();
    }


    public function getBuyCondition() {

            //$this->bb->getBandWidth() >= 1.8 && $this->bb->getBandWidth() <= 3
        return $this->isUpTrend() && $this->hasUpPattern() && !$this->hasReversePattern();
    }

    public function isUpTrend() {
        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        if ($last100[$count - 2]->sma - $last100[$count - 22]->sma > $last100[$count - 2]->sd * 2) {
            $this->strongBuy = true;
            return true;
        } else {
            $this->strongBuy = false;
        }

        if ($last100[$count - 2]->sma - $last100[$count - 22]->sma > 0.4 && $last100[$count - 2]->sd < 0.75) {
            return true;
        }

        return false;
    }

    public function hasReversePattern() {
        $lastData = $this->bb->getLastData();
        $count = count($lastData);

        for ($i = 0; $i < 10; $i++) {
            if ($lastData[$count-2-$i]->high > $lastData[$count-2-$i]->upper) {
                return false;
            }
        }
        return true;
    }


    public function hasUpPattern() {
        $lastData = $this->bb->getLastData();
        $count = count($lastData);

        $red = 0;
        $green = 0;

        $lastPrice = $lastData[$count-1];

        if ($lastData[$count-2]->sma - $lastPrice->open < 0) {
            $red++;
        }

        for ($i = 0; $i < 4; $i++) {
            if ($lastData[$count-2-$i]->close < $lastData[$count-2-$i]->sma || $lastData[$count-2-$i]->open < $lastData[$count-2-$i]->sma) {
                return false;
            }
            if ($lastData[$count-2-$i]->high > $lastData[$count-2-$i]->upper) {
                return false;
            }

            if ($lastData[$count-2-$i]->close > $lastData[$count-2-$i]->open) {
                $green++;
            } else {
                $red++;
            }
        }
        return ($green >= 4 || $red >= 4) && ($this->strongBuy || $this->hasBreakPattern());
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
