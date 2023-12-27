<?php

namespace App\Strategies;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;

class Strategy16 extends Strategy10 {

    protected $bb;

    public function __construct() {
        parent::__construct();
    }

    public function canSell() {
        $return = ($this->bb->meetSma() &&  $this->getSellCondition());
        return $return;
    }

    public function getSellCondition() {

        $result =  $this->hasMoreLowCandles() && $this->hasNoStrongBuy() && $this->noUpperExpand() && $this->noUpCandle() && $this->isDownTrend();
        return $result;
    }

    public function hasMoreLowCandles() {
        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        if (count($last100) < 63) {
            return false;
        }
        return parent::hasMoreLowCandles();
    }

    public function isDownTrend() {

        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        $check1 = $last100[$count - 9]->sma - $last100[$count - 2]->sma;
        $check2 = $last100[$count - 16]->sma - $last100[$count - 9]->sma;
        $check3 = $last100[$count - 23]->sma - $last100[$count - 16]->sma;


        $result = $check1 >= 0.4 && $check2 > 0 && $check3 > -0.2 && $check1 > $check2 / 2;

        if ($result) {
            $currentSma = $last100[$count - 1]->sma;
            for ($i = 0; $i < 15; $i++) {
                $lastData = PriceFactory::shift();
                $count = count($lastData);
                $this->update();

                //echo date('Y-m-d H:i:s', $lastData[$count-1]->time) . ' ' . $lastData[$count - 2]->high . ' ' . $lastData[$count - 3]->upper . PHP_EOL;

                if ($lastData[$count - 1]->high > $lastData[$count - 2]->upper && $lastData[$count - 2]->sma <= $currentSma) {
                    $upper = $this->bb->getUpper();
                    $sd = $this->bb->getSd();
                    $this->setData(
                        [
                            'direction' => 'sell',
                            'price' => $upper,
                            'sl'    => $upper + 2,
                            'tp'    => $upper - 4
                        ]
                    );
                    return true;
                }
            }

        }
        return false;

    }

    public function shouldCloseOrder() {

        if ($this->bb->meetLowerBand() && $this->trendStopped()) {
            $this->setClosePrice($this->bb->getLower() + Order::SPREAD);
            return true;
        }

        return false;
    }

    public function trendStopped() {
        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        return $last100[$count - 22]->sma - $last100[$count - 2]->sma < 0;
    }
}
