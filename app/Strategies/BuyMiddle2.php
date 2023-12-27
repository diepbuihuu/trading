<?php
namespace App\Strategies;
use App\Indicators\BollingerBand;
use App\Models\Order;

class BuyMiddle2 extends Strategy {

    protected $expectLoss = 2;
    protected $expectGain = 4;

    public function canBuy() {
        $lastData = $this->bb->getLastData();
        $count = count($lastData);

        $newSma = $lastData[$count - 2]->sma * 2 - $lastData[$count - 3]->sma;
        $return = ($lastData[$count-1]->low < $newSma &&  $this->getBuyCondition());

        $price = $newSma + Order::SPREAD;
        if ($return) {
            $sma = $this->bb->getSma();
            $this->setData(
                [
                    'direction' => 'buy',
                    'price' => $price,
                    'sl'    => $price - $this->expectLoss,
                    'tp'    => $price + $this->expectGain
                ]
            );
        }

        return $return;
    }

    public function getBuyCondition() {
        return true;
    }
}
