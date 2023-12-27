<?php
namespace App\Strategies;
use Database\Factories\PriceFactory;
use App\Models\Order;

class BuyDelay extends Strategy {

    protected $expectLoss = 2;
    protected $expectGain = 4;

    protected $maxShift = 15;

    public function canBuy() {
        $return = $this->getBuyCondition();

        if ($return) {
            $return = false;
            for ($i = 0; $i < $this->maxShift; $i++) {
                $lastData = PriceFactory::shift();
                $this->update();
                $count = count($lastData);
                $price = ($lastData[$count-1]->open + $lastData[$count-1]->close)/2;

                if ($this->getBuyCondition2()) {
                    $this->setData(
                        [
                            'direction' => 'buy',
                            'price' => $price,
                            'sl'    => $price - $this->expectLoss,
                            'tp'    => $price + $this->expectGain
                        ]
                    );
                    $return = true;
                    break;
                }
            }
        }

        return $return;
    }

    public function getBuyCondition() {
        return false;
    }

    public function getBuyCondition2() {
        return false;
    }
}
