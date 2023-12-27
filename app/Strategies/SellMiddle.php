<?php
namespace App\Strategies;
use App\Indicators\BollingerBand;

class SellMiddle extends Strategy {

    protected $expectLoss = 2;
    protected $expectGain = 4;

    public function canSell() {
        $return = ($this->bb->meetSma() &&  $this->getSellCondition());

        if ($return) {
            $sma = $this->bb->getSma();
            $sd = $this->bb->getSd();
            $this->setData(
                [
                    'direction' => 'sell',
                    'price' => $sma,
                    'sl'    => $sma + $this->expectLoss,
                    'tp'    => $sma - $this->expectGain
                ]
            );
        }

        return $return;
    }

    public function getSellCondition() {
        return true;
    }
}
