<?php
namespace App\Strategies;
use App\Indicators\BollingerBand;
use App\Models\Order;

class BuyBottom extends Strategy {

    protected $expectLoss = 2;
    protected $expectGain = 4;

    public function canBuy() {
        $return = ($this->bb->meetLowerBand() && $this->getBuyCondition());

        if ($return) {
            $lower = $this->bb->getLower() + Order::SPREAD;
            $this->setData(
                [
                    'direction' => 'buy',
                    'price' => $lower,
                    'sl'    => $lower - $this->expectLoss,
                    'tp'    => $lower + $this->expectGain
                ]
            );
        }

        return $return;
    }

    public function getBuyCondition() {
        return true;
    }
}
