<?php
namespace App\Strategies;
use App\Indicators\BollingerBand;
use App\Models\Order;

class BuyMiddle extends Strategy {

    protected $expectLoss = 2;
    protected $expectGain = 4;

    public function canBuy() {
        $return = ($this->bb->meetSma() &&  $this->getBuyCondition());

        if ($return) {
            $sma = $this->bb->getSma() + Order::SPREAD;
            $this->setData(
                [
                    'direction' => 'buy',
                    'price' => $sma,
                    'sl'    => $sma - $this->expectLoss,
                    'tp'    => $sma + $this->expectGain
                ]
            );
        }

        return $return;
    }

    public function getBuyCondition() {
        return true;
    }
}
