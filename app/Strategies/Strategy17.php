<?php

namespace App\Strategies;
use App\Indicators\BollingerBand;

class Strategy1 extends Strategy {

    protected $bb;

    public function __construct() {
        $this->bb = new BollingerBand();
    }

    public function update() {
        $this->bb->update();
    }

    public function canBuy() {
        return false;
    }

    public function canSell() {
        $return = ($this->bb->meetUpperBand() && $this->bb->getBandWidth() >= 1.8 && $this->bb->getBandWidth() <= 3 && $this->bb->isClosingBand());

        if ($return) {
            $upper = $this->bb->getUpper();
            $sd = $this->bb->getSd();
            $this->setData(
                [
                    'price' => $upper,
                    'sl'    => $upper + $sd * 3,
                    'tp'    => $upper - $sd * 3
                ]
            );
        }

        return $return;
    }
}
