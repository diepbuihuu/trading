<?php

namespace App\Strategies;
use App\Indicators\BollingerBand;

class Strategy {
    protected $direction = '';
    protected $price = 0;
    protected $stopLoss = 0;
    protected $takeProfit = 0;
    protected $closePrice = 0;
    protected $openTime = 0;

    protected $bb;
    protected $trendThreshold = 2;

    public static function getStrategy($id) {

        $strategyName = self::class . $id;
        return new $strategyName;
    }

    public function __construct() {
        $this->bb = new BollingerBand();
    }

    public function update() {
        $this->bb->update();
    }

    public function isIncreasing() {
        return ($this->bb->getLastPrice() > $this->bb->getFirstPrice());
    }

    public function isDecreasing() {
        return ($this->bb->getLastPrice() < $this->bb->getFirstPrice());
    }

    public function isUpTrend() {
        return ($this->bb->getLastPrice() > $this->bb->getFirstPrice() + $this->trendThreshold);
    }

    public function isDownTrend() {
        return ($this->bb->getLastPrice() < $this->bb->getFirstPrice() - $this->trendThreshold);
    }

    public function setData($data) {

        $this->direction = $data['direction'];
        $this->price = $data['price'];
        $this->stopLoss = $data['sl'];
        $this->takeProfit = $data['tp'];

        $this->openTime = $this->bb->getTime();
    }

    public function setClosePrice($price) {
        $this->closePrice = $price;
    }

    public function setStopLoss($sl) {
        $this->stopLoss = $sl;
    }

    public function setTakeProfit($tp) {
        $this->takeProfit = $tp;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getOpenTime() {
        return $this->openTime;
    }

    public function getStopLoss() {
        return $this->stopLoss;
    }

    public function getTakeProfit() {
        return $this->takeProfit;
    }

    public function getClosePrice() {
        return $this->closePrice;
    }

    public function canBuy() {
        return false;
    }

    public function canSell() {
        return false;
    }

    public function shouldCloseOrder() {
        return false;
    }

    public function shouldChangeStopLoss() {
        return false;
    }

    public function shouldChangeTakeProfit() {
        return false;
    }
}
