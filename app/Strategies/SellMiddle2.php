<?php
namespace App\Strategies;
use App\Indicators\BollingerBand;

class SellMiddle2 extends Strategy {

    protected $expectLoss = 2;
    protected $expectGain = 4;

    public function canSell() {
        $lastData = $this->bb->getLastData();
        $count = count($lastData);

        $newSma = $lastData[$count - 2]->sma * 2 - $lastData[$count - 3]->sma;
        $return = ($lastData[$count-1]->high > $newSma &&  $this->getSellCondition());

        if ($return) {
            $sma = $newSma;
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
