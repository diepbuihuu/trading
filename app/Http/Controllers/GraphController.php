<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;
use App\Models\Bb;
use App\Models\Price5;
use App\Models\Bb5;
use App\Models\Price15;
use App\Models\Bb15;

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

    public function getDataForDate($startTime) {

        $startTime = Price15::where('time', '<=', $startTime)->orderBy('time', 'desc')->first()->time;

        $prices = Price::where('time', '<', $startTime)->orderBy('time', 'desc')->take(150)->get()->toArray();
        $candles = array_map(function($p) {
            return [$p['time'], $p['open'], $p['high'], $p['low'], $p['close']];
        }, $prices);

        $bbs = Bb::where('time', '<', $startTime)->orderBy('time', 'desc')->take(150)->get()->toArray();
        $bbData = array_map(function($p) {
            return [$p['time'], $p['sma'], $p['sd'], $p['upper'], $p['lower']];
        }, $bbs);

        $price5s = Price5::where('time', '<', $startTime)->orderBy('time', 'desc')->take(150)->get()->toArray();
        $candle5s = array_map(function($p) {
            return [$p['time'], $p['open'], $p['high'], $p['low'], $p['close']];
        }, $price5s);

        $bb5s  = Bb5::where('time', '<', $startTime)->orderBy('time', 'desc')->take(150)->get()->toArray();

        $bb5Data = array_map(function($p) {
            return [$p['time'], $p['sma'], $p['sd'], $p['upper'], $p['lower']];
        }, $bb5s);

        $price15s = Price15::where('time', '<', $startTime)->orderBy('time', 'desc')->take(150)->get()->toArray();
        $candle15s = array_map(function($p) {
            return [$p['time'], $p['open'], $p['high'], $p['low'], $p['close']];
        }, $price15s);

        $bb15s  = Bb15::where('time', '<', $startTime)->orderBy('time', 'desc')->take(150)->get()->toArray();

        $bb15Data = array_map(function($p) {
            return [$p['time'], $p['sma'], $p['sd'], $p['upper'], $p['lower']];
        }, $bb15s);

        return [
            'candles' => array_reverse($candles),
            'bb_data' => array_reverse($bbData),
            'm5_candles' => array_reverse($candle5s),
            'm5_bb_data' => array_reverse($bb5Data),
            'm15_candles' => array_reverse($candle15s),
            'm15_bb_data' => array_reverse($bb15Data),
        ];
    }

    public function getFutureDataForDate($startTime) {
        $startTime = Price15::where('time', '<=', $startTime)->orderBy('time', 'desc')->first()->time;

        $prices = Price::where('time', '>=', $startTime)->orderBy('time')->take(180)->get()->toArray();
        $candles = array_map(function($p) {
            return [$p['time'], $p['open'], $p['high'], $p['low'], $p['close']];
        }, $prices);

        $bbs = Bb::where('time', '>=', $startTime)->orderBy('time')->take(180)->get()->toArray();
        $bbData = array_map(function($p) {
            return [$p['time'], $p['sma'], $p['sd'], $p['upper'], $p['lower']];
        }, $bbs);

        $price5s = Price5::where('time', '>=', $startTime)->orderBy('time')->take(36)->get()->toArray();
        $candle5s = array_map(function($p) {
            return [$p['time'], $p['open'], $p['high'], $p['low'], $p['close']];
        }, $price5s);

        $bb5s  = Bb5::where('time', '>=', $startTime)->orderBy('time')->take(36)->get()->toArray();

        $bb5Data = array_map(function($p) {
            return [$p['time'], $p['sma'], $p['sd'], $p['upper'], $p['lower']];
        }, $bb5s);

        $price15s = Price15::where('time', '>=', $startTime)->orderBy('time')->take(12)->get()->toArray();
        $candle15s = array_map(function($p) {
            return [$p['time'], $p['open'], $p['high'], $p['low'], $p['close']];
        }, $price15s);

        $bb15s  = Bb15::where('time', '>=', $startTime)->orderBy('time')->take(12)->get()->toArray();

        $bb15Data = array_map(function($p) {
            return [$p['time'], $p['sma'], $p['sd'], $p['upper'], $p['lower']];
        }, $bb15s);

        return [
            'candles' => $candles,
            'bb_data' => $bbData,
            'm5_candles' => $candle5s,
            'm5_bb_data' => $bb5Data,
            'm15_candles' => $candle15s,
            'm15_bb_data' => $bb15Data,
        ];
    }
}
