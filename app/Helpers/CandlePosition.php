<?php

namespace App\Helpers;

class CandlePosition {
    public static function crossSma($price) {
        return ($price->low <= $price->sma && $price->high >= $price->sma);
    }

    public static function crossUpper($price) {
        return ($price->high > $price->upper);
    }

    public static function crossLower($price) {
        return ($price->low < $price->lower);
    }

    public static function belowSma($price, $strict = 0) {
        $result = ($price->open < $price->sma && $price->close < $price->sma);

        if ($strict == 1) {
            return $result && $price->high < $price->sma;
        }
        if ($strict == 2) {
            return $result && $price->high < $price->sma && $price->low > $price->lower;
        }
        return $result;
    }

    public static function aboveSma($price, $strict = 0) {
        $result = ($price->open > $price->sma && $price->close > $price->sma);

        if ($strict == 1) {
            return $result && $price->low > $price->sma;
        }
        if ($strict == 2) {
            return $result && $price->low > $price->sma && $price->high < $price->upper;
        }
        return $result;
    }

    public static function breakLower($price, $strict = 0) {
        $result = $price->close < $price->lower;

        if ($strict == 1) {
            return $result || $price->open < $price->lower;
        }
        return $result;
    }
    public static function breakUpper($price, $strict = 0) {
        $result = $price->close > $price->upper;

        if ($strict == 1) {
            return $result || $price->open > $price->upper;
        }
        return $result;
    }

    public static function closeToSma($price, $position = 'below') {
        if ($position === 'below') {
            return $price->open < $price->sma && $price->close < $price->sma && $price->open > ($price->sma - $price->sd) && $price->close > ($price->sma - $price->sd);
        } else {
            return $price->open > $price->sma && $price->close > $price->sma && $price->open < ($price->sma + $price->sd) && $price->close < ($price->sma + $price->sd);
        }
    }
}
