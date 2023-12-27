<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Price;
use App\Models\Bb;

class StrategyController extends Controller
{
    public function index($strategyID) {
        return $this->report($strategyID, range(0, 23));
    }

    public function reportUS($strategyID) {
        return $this->report($strategyID, [19,20,21,22,23]);
    }

    public function report($strategyID, $hours) {
        $orders = Order::where('strategy_id', $strategyID)->get();
        $reportData = [];

        $datesSummary = [];
        $hoursSummary = array_fill(0, 24, [0,0,0,0]);
        $summary = [0,0,0,0];

        foreach ($orders as $o) {
            $date = date('Y-m-d', $o->open_time);
            $hour = date('G', $o->open_time);

            if (!in_array($hour, $hours)) {
                continue;
            }

            if (!isset($reportData[$date])) {
                $reportData[$date] = [];
                $datesSummary[$date] = [0,0,0,0];
            }
            if (!isset($reportData[$date][$hour])) {
                $reportData[$date][$hour] = [0,0,0,0, strtotime($date . ' ' . $hour . ':00:00')];
            }

            if ($o->profit < 0) {
                $reportData[$date][$hour][0] ++;
                $datesSummary[$date][0] ++;
                $hoursSummary[$hour][0] ++;
                $summary[0] ++;
            } else if ($o->profit > 0) {
                $reportData[$date][$hour][1] ++;
                $datesSummary[$date][1] ++;
                $hoursSummary[$hour][1] ++;
                $summary[1] ++;
            } else {
                $reportData[$date][$hour][2] ++;
            }
            $reportData[$date][$hour][3] += $o->profit;
            $datesSummary[$date][3] += $o->profit;
            $hoursSummary[$hour][3] += $o->profit;
            $summary[3] += $o->profit;
        }

        return view('strategy.report', [
            'strategyID' => $strategyID,
            'data' => $reportData,
            'hours' => $hours,
            'datesSummary' => $datesSummary,
            'hoursSummary' => $hoursSummary,
            'summary' => $summary
        ]);
    }

    public function drawGraph($strategyID, $startTime) {
        return view('graph.index');
    }

    public function getData($strategyID, $startTime) {

        $prices = Price::where('time', '>=', $startTime - 30 * 60)->orderBy('time')->take(120)->get()->toArray();
        $candles = array_map(function($p) {
            return [$p['time'], $p['open'], $p['high'], $p['low'], $p['close']];
        }, $prices);

        $bbs = Bb::where('time', '>=', $startTime - 30 * 60)->orderBy('time')->take(120)->get()->toArray();
        $bbData = array_map(function($p) {
            return [$p['time'], $p['sma'], $p['sd'], $p['upper'], $p['lower']];
        }, $bbs);
        $orders = Order::where('strategy_id', $strategyID)
                        ->where('open_time', '>=', $startTime)
                        ->where('open_time', '<=', $startTime + 3600)
                        ->get()->toArray();

        return [
            'candles' => $candles,
            'bb_data' => $bbData,
            'orders'  => $orders
        ];
    }
}
