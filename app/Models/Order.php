<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    CONST SPREAD = 0.125;

    protected $fillable =[
        'strategy_id',
        'direction',
        'open_time',
        'close_time',
        'open_price',
        'stop_loss',
        'take_profit',
        'close_price',
        'profit',
    ];


    public static function buy($strategyID, $time, $price) {
        return self::create([
            'strategy_id' => $strategyID,
            'direction' => 'buy',
            'open_time' => $time,
            'open_price' => $price
        ]);
    }

    public static function sell($strategyID, $time, $price) {
        return self::create([
            'strategy_id' => $strategyID,
            'direction' => 'sell',
            'open_time' => $time,
            'open_price' => $price
        ]);
    }

    public function setStopLoss($st) {
        if (
                ($this->direction === 'buy' && $st <= $this->open_price) ||
                ($this->direction === 'sell' && $st >= $this->open_price)
        ) {
            $this->stop_loss = $st;
            return true;
        }
        return false;

    }

    public function setTakeProfit($tp) {
        if (
                ($this->direction === 'buy' && $tp >= $this->open_price) ||
                ($this->direction === 'sell' && $tp <= $this->open_price)
        ) {
            $this->take_profit = $tp;
            return true;
        }
        return false;
    }

    public function isStopLoss($price) {
        if (
                ($this->direction === 'buy' && $price->low < $this->stop_loss) ||
                ($this->direction === 'sell' && $price->high + self::SPREAD > $this->stop_loss)
        ) {
            $this->close_time = $price->time;
            $this->close_price = $this->stop_loss;
            $this->profit = -1 * round(abs($this->stop_loss - $this->open_price), 2);
            $this->save();
            echo 'SL' . PHP_EOL;
            return true;
        }
        return false;
    }

    public function close($time, $price) {
        $this->close_time = $time;
        $this->close_price = $price;
        $this->profit = $price - $this->open_price;
        if ($this->direction === 'sell') {
            $this->profit *= -1;
        }
        $this->save();
    }

    public function isTakeProfit($price) {
        if (
                ($this->direction === 'buy' && $price->high > $this->take_profit) ||
                ($this->direction === 'sell' && $price->low + self::SPREAD < $this->take_profit)
        ) {
            $this->close_time = $price->time;
            $this->close_price = $this->take_profit;
            $this->profit = round(abs($this->take_profit - $this->open_price), 2);
            $this->save();
            echo 'TP' . PHP_EOL;
            return true;
        }
        return false;
    }
}
