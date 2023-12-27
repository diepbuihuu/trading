<?php
namespace App\Strategies;
use App\Indicators\BollingerBand;

class SellTop extends Strategy {

    protected $expectLoss = 2;
    protected $expectGain = 4;

    public function canSell() {
        $return = ($this->bb->meetUpperBand() &&  $this->getSellCondition());

        if ($return) {
            $upper = $this->bb->getUpper();
            $sd = $this->bb->getSd();
            $this->setData(
                [
                    'direction' => 'sell',
                    'price' => $upper,
                    'sl'    => $upper + $this->expectLoss,
                    'tp'    => $upper - $this->expectGain
                ]
            );
        }

        return $return;
    }

    public function getSellCondition() {
        return true;
    }
}
