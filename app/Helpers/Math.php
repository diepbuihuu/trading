<?php

namespace App\Helpers;

class Math {

    public static function sd($data, $sma = 0) {
        if (!$sma) {
            $sma = self::average($data);
        }
        $result = 0;
        $count = 0;
        foreach ($data as $price) {
            $result += pow($price - $sma, 2);
            $count ++;
        }

        return round(sqrt($result / $count), 2);
    }

    public static function average($data) {
        $result = 0;
        $count = 0;
        foreach ($data as $price) {
            $result += $price;
            $count ++;
        }
        return round($result / $count, 2);
    }

    public static function differ($data) {
        return round(max($data) - min($data), 2);
    }

    public static function isIncreasing($data, $milestones, $rates) {
        foreach ($milestones as $i => $m) {
            $set1 = [];
            $set2 = [];
            for ($j = 0; $j < $m; $j++) {
                $set1[] = $data[$j];
            }
            for ($j = $m; $j < $m * 2; $j++) {
                $set2[] = $data[$j];
            }

            if (self::average($set1) > self::average($set2) * $rates[$i]) {
                return false;
            }
        }
        return true;
    }

    public static function isDecreasing($data, $milestones, $rates) {
        foreach ($milestones as $i => $m) {
            $set1 = [];
            $set2 = [];
            for ($j = 0; $j < $m; $j++) {
                $set1[] = $data[$j];
            }
            for ($j = $m; $j < $m * 2; $j++) {
                $set2[] = $data[$j];
            }

            if (self::average($set1) < self::average($set2) * $rates[$i]) {
                return false;
            }
        }
        return true;
    }
}
