<?php
namespace App\Strategies;
use App\Indicators\BollingerBand;

class SellNow extends Strategy {

    protected $expectLoss = 2;
    protected $expectGain = 4;

    public function canSell() {
        $return = $this->getSellCondition();

        if ($return) {
            $lastData = $this->bb->getLastData();
            $count = count($lastData);
            $price = ($lastData[$count-1]->open + $lastData[$count-1]->close)/2;
            $this->setData(
                [
                    'direction' => 'sell',
                    'price' => $price,
                    'sl'    => $price + $this->expectLoss,
                    'tp'    => $price - $this->expectGain
                ]
            );
        }

        return $return;
    }

    public function getSellCondition() {
        return true;
    }
}
