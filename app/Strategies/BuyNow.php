<?php
namespace App\Strategies;
use App\Indicators\BollingerBand;
use App\Models\Order;

class BuyNow extends Strategy {

    protected $expectLoss = 2;
    protected $expectGain = 4;

    public function canBuy() {
        $return = $this->getBuyCondition();

        if ($return) {
            $lastData = $this->bb->getLastData();
            $count = count($lastData);
            $price = ($lastData[$count-1]->open + $lastData[$count-1]->close)/2;
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
