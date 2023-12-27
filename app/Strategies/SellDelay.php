<?php
namespace App\Strategies;
use Database\Factories\PriceFactory;

class SellDelay extends Strategy {

    protected $expectLoss = 2;
    protected $expectGain = 4;

    protected $maxShift = 15;

    public function canSell() {
        $return = $this->getSellCondition();

        if ($return) {
            $return = false;
            for ($i = 0; $i < $this->maxShift; $i++) {
                $lastData = PriceFactory::shift();
                $this->update();
                $count = count($lastData);
                $price = ($lastData[$count-1]->open + $lastData[$count-1]->close)/2;

                if ($this->getSellCondition2()) {
                    $this->setData(
                        [
                            'direction' => 'sell',
                            'price' => $price,
                            'sl'    => $price + $this->expectLoss,
                            'tp'    => $price - $this->expectGain
                        ]
                    );
                    $return = true;
                    break;
                }
            }
        }

        return $return;
    }

    public function getSellCondition() {
        return false;
    }

    public function getSellCondition2() {
        return false;
    }
}
