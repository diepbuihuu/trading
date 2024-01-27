<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;
use App\Models\Bb;
use App\Models\Price5;
use App\Models\Bb5;
use App\Models\Price15;
use App\Models\Bb15;
use App\Models\Price60;
use App\Models\Bb60;

class GraphController extends Controller
{
    public function index() {
        $start = 1693252800 + 17 * 3600;
        return view('graph.index', [
            'start' => $start
        ]);
    }

    public function manual($start) {
        return view('graph.manual', [
            'start' => $start
        ]);
    }

    public function getData() {
        $startTime = 1693252800 + 17 * 3600;
        return $this->getDataForDate($startTime);
    }

    public function chooseDate() {
        return view('graph.choose_date', [
            'start' => '08/21/2023'
        ]);
    }

    public function getDataForDate($startTime) {

        $startTime = Price60::where('time', '<=', $startTime)->orderBy('time', 'desc')->first()->time;
        $limit = 150;

        $candles = Price::getPastData($startTime, $limit);
        $candle5s = Price5::getPastData($startTime, $limit);
        $candle15s = Price15::getPastData($startTime, $limit);
        $candle60s = Price60::getPastData($startTime, $limit);

        $bbData = Bb::getPastData($startTime, $limit);
        $bb5Data = Bb5::getPastData($startTime, $limit);
        $bb15Data = Bb15::getPastData($startTime, $limit);
        $bb60Data = Bb60::getPastData($startTime, $limit);

        return [
            'candles' => $candles,
            'bb_data' => $bbData,
            'm5_candles' => $candle5s,
            'm5_bb_data' => $bb5Data,
            'm15_candles' => $candle15s,
            'm15_bb_data' => $bb15Data,
            'm60_candles' => $candle60s,
            'm60_bb_data' => $bb60Data,
        ];
    }

    public function getFutureDataForDate($startTime) {
        $startTime = Price60::where('time', '<=', $startTime)->orderBy('time', 'desc')->first()->time;

        $candles = Price::getFutureData($startTime, 180);
        $candle5s = Price5::getFutureData($startTime, 36);
        $candle15s = Price15::getFutureData($startTime, 12);
        $candle60s = Price60::getFutureData($startTime, 3);

        $bbData = Bb::getFutureData($startTime, 180);
        $bb5Data = Bb5::getFutureData($startTime, 36);
        $bb15Data = Bb15::getFutureData($startTime, 12);
        $bb60Data = Bb60::getFutureData($startTime, 3);

        return [
            'candles' => $candles,
            'bb_data' => $bbData,
            'm5_candles' => $candle5s,
            'm5_bb_data' => $bb5Data,
            'm15_candles' => $candle15s,
            'm15_bb_data' => $bb15Data,
            'm60_candles' => $candle60s,
            'm60_bb_data' => $bb60Data,
        ];
    }
}
