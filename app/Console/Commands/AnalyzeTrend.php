<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Factories\PriceFactory;
use App\Models\Order;

class AnalyzeTrend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analyze_trend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'See how long does a trend last';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $startTime = strtotime('2023-08-20');
        $endTime = strtotime('2023-08-31');
        $currentTime = $startTime;
        $dataLength = PriceFactory::DATA_LENGTH;
        PriceFactory::setStartTime($startTime);

        $hasOrder = false;
        $trend = '';
        $high = false;
        $low = false;
        $highTime = 0;
        $lowTime = 0;

        while ($currentTime <= $endTime) {

            $lastData = PriceFactory::shift();
            $currentPrice = $lastData[$dataLength - 1];
            $currentTime = $currentPrice->time;

            if (date('G', $currentTime) < 18 && !$highTime && !$lowTime) {
                continue;
            }

            if (!$high) {
                $high = $currentPrice->high;
                $highTime = $currentPrice->time;
            }
            if (!$low) {
                $low = $currentPrice->low;
                $lowTime = $currentPrice->time;
            }


            if ($currentPrice->low < $high - 4) {
                $trend = 'down';

                if ($highTime > $lowTime) {
                    echo date('Y-m-d H:i:s', $lowTime) . ' ' . ($highTime - $lowTime) / 60 . ' ' . $high . ' ' . round($high - $low, 2) . PHP_EOL;
                    if (date('G', $currentTime) < 18) {
                        $highTime = 0;
                        $lowTime = 0;
                        $high = false;
                        $low = false;
                        continue;
                    }
                    $low = $currentPrice->low;
                    $lowTime = $currentPrice->time;
                }


            }

            if ($currentPrice->high > $low + 4) {
                $trend = 'up';

                if ($highTime < $lowTime) {
                    echo date('Y-m-d H:i:s', $highTime) . ' ' . ($lowTime - $highTime) / 60 . ' ' . round($low - $high, 2) . PHP_EOL;
                    if (date('G', $currentTime) < 18) {
                        $highTime = 0;
                        $lowTime = 0;
                        $high = false;
                        $low = false;
                        continue;
                    }
                    $high = $currentPrice->high;
                    $highTime = $currentPrice->time;
                }
            }

            if ($currentPrice->high > $high) {
                $high = $currentPrice->high;
                $highTime = $currentPrice->time;
            }

            if ($currentPrice->low < $low) {
                $low = $currentPrice->low;
                $lowTime = $currentPrice->time;
            }

        }
    }
}
