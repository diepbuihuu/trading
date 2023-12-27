<?php

namespace App\Strategies;
use Database\Factories\PriceFactory;
use App\Models\Order;
use App\Helpers\Math;

class Strategy14 extends Strategy10 {

    protected $bb;

    public function __construct() {
        parent::__construct();
    }

    public function canSell() {
        $return = ($this->bb->meetSma() &&  $this->getSellCondition());

        if ($return) {
            $sma = $this->bb->getSma();
            $sd = $this->bb->getSd();
            $this->setData(
                [
                    'direction' => 'sell',
                    'price' => $sma,
                    'sl'    => $sma + 2,
                    'tp'    => $sma - 4
                ]
            );
        }

        return $return;
    }

    public function getSellCondition() {

        $result =  parent::getSellCondition();

        if ($result) {
            $last100 = PriceFactory::getLast100();
            $count = count($last100);

            $check1 = $last100[$count - 9]->sma - $last100[$count - 2]->sma;
            echo $check1 . ' ' . $last100[$count - 2]->sd . ' ';
        }

        return $result;
    }


    public function isDownTrend() {

        $last100 = PriceFactory::getLast100();
        $count = count($last100);

        if (count($last100) < 63) {
            return false;
        }

        $check1 = $last100[$count - 9]->sma - $last100[$count - 2]->sma;
        $check2 = $last100[$count - 16]->sma - $last100[$count - 9]->sma;
        $check3 = $last100[$count - 23]->sma - $last100[$count - 16]->sma;
        $check4 = $last100[$count - 62]->sma - $last100[$count - 2]->sma;

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
