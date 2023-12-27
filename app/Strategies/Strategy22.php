<?php

namespace App\Strategies;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;

class Strategy22 extends SellNow {

    protected $bb;

    public function __construct() {
        parent::__construct();
    }

    public function getSellCondition() {
        return  $this->hasDownPattern();
    }

    public function hasDownPattern() {
        $lastData = $this->bb->getLastData();
        $count = count($lastData);
        $result1  = (
                        $lastData[$count - 2]->close < $lastData[$count - 2]->sma &&
                        $lastData[$count - 3]->close < $lastData[$count - 3]->sma &&
                        $lastData[$count - 4]->close < $lastData[$count - 4]->sma &&
                        $lastData[$count - 2]->low > $lastData[$count - 2]->lower &&
                        $lastData[$count - 3]->low > $lastData[$count - 3]->lower &&
                        $lastData[$count - 4]->low > $lastData[$count - 4]->lower &&
                        $lastData[$count - 5]->close < $lastData[$count - 5]->sma &&
                        $lastData[$count - 5]->high > $lastData[$count - 5]->upper
                  );
          return $result1;
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
