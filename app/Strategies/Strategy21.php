<?php

namespace App\Strategies;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;

class Strategy21 extends Strategy7 {

    protected $bb;
    protected $stableThreshold = 0.5;

    public function __construct() {
        parent::__construct();
    }

    public function canBuy() {
        $return = $this->getBuyCondition();

        if ($return) {
            $lastData = $this->bb->getLastData();
            $count = count($lastData);
            $price = ($lastData[$count-1]->open + $lastData[$count-1]->close)/2 + Order::SPREAD;
            $this->setData(
                [
                    'direction' => 'sell',
                    'price' => $price,
                    'sl'    => $price - 2,
                    'tp'    => $price + 2
                ]
            );
        }

        return $return;
    }

    public function getBuyCondition() {

            //$this->bb->getBandWidth() >= 1.8 && $this->bb->getBandWidth() <= 3
        return  $this->hasUpPattern();
    }

    public function hasUpPattern() {

        $lastData = $this->bb->getLastData();
        $count = count($lastData);
        $slowCandlesCount = 0;

        for ($i = 0; $i < 10; $i++) {
            if ($lastData[$count-2-$i]->high < $lastData[$count-2-$i]->sma && $lastData[$count-2-$i]->low > $lastData[$count-2-$i]->lower) {
                $slowCandlesCount++;
            }
        }

        return ($slowCandlesCount == 10);
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
