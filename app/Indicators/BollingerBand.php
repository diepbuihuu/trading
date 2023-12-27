<?php

namespace App\Indicators;
use Database\Factories\PriceFactory;
use App\Helpers\Math;

class BollingerBand {

    /**
    *
    */
    protected $lastData = [];

    protected $count = [];

    public function update() {
        $this->lastData = PriceFactory::getLatest();
        $this->count = count($this->lastData);
    }

    public function meetUpperBand($buffer = 0) {
        if ($this->count < PriceFactory::DATA_LENGTH) {
            return false;
        }

        return ($this->lastData[$this->count - 1]->high > $this->lastData[$this->count-2]->upper + $buffer);
    }

    public function meetLowerBand($buffer = 0) {
        if ($this->count < PriceFactory::DATA_LENGTH) {
            return false;
        }

        return ($this->lastData[$this->count - 1]->low < $this->lastData[$this->count-2]->lower - $buffer);
    }

    public function aboveSma($buffer = 0) {
        if ($this->count < PriceFactory::DATA_LENGTH) {
            return false;
        }

        return $this->lastData[$this->count - 1]->high > ($this->lastData[$this->count - 2]->sma + $buffer);
    }

    public function belowSma($buffer = 0) {
        if ($this->count < PriceFactory::DATA_LENGTH) {
            return false;
        }

        return $this->lastData[$this->count - 1]->low < ($this->lastData[$this->count-2]->sma + $buffer);
    }

    public function meetSma($buffer = 0) {
        if ($this->count < PriceFactory::DATA_LENGTH) {
            return false;
        }

        return (
            $this->lastData[$this->count - 1]->low < $this->lastData[$this->count-2]->sma + $buffer &&
            $this->lastData[$this->count - 1]->high > $this->lastData[$this->count - 2]->sma + $buffer
        );

    }

    public function getLastData() {
        return $this->lastData;
    }

    public function isClosingBand() {
        return $this->lastData[$this->count - 2]->sd <= $this->lastData[$this->count - 3]->sd;
    }

    public function getBandWidth() {
        return $this->lastData[$this->count - 2]->upper - $this->lastData[$this->count - 2]->lower;
    }

    public function getUpper() {
        return $this->lastData[$this->count - 2]->upper;
    }

    public function getLower() {
        return $this->lastData[$this->count - 2]->lower;
    }

    public function getSma() {
        return $this->lastData[$this->count - 2]->sma;
    }
    public function getSd() {
        return $this->lastData[$this->count - 2]->sd;
    }

    public function getNextPrice() {
        return ($this->lastData[$this->count - 1]->open + $this->lastData[$this->count - 1]->close) / 2;
    }

    public function getFirstPrice() {
        return $this->lastData[0]->sma;
    }

    public function getLastPrice() {
        return $this->lastData[$this->count - 2]->sma;
    }

    public function getTime() {
        return $this->lastData[$this->count - 1]->time;
    }
}
