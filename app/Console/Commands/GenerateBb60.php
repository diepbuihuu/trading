<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Price60;
use App\Models\Bb60;

class GenerateBb60 extends Command
{
    const DATA_LENGTH = 20;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate_bb60';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generating Bollinger Band data from Price';

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
        $time = 0;
        $data = [];

        while (true) {
            $prices = Price60::where('time', '>', $time)->orderBy('time')->take(100)->get();
            if (count($prices) === 0) {
                break;
            }

            foreach ($prices as $p) {
                if (count($data) >= self::DATA_LENGTH) {
                    array_shift($data);
                }
                $data[] = $p;

                $sma = $this->generateSma($data);
                $sd = $this->generateSd($data, $sma);

                $bb = Bb60::firstOrCreate(
                    ['time' => $p->time],
                    [
                        'sma' => round($sma, 2),
                        'sd' => round($sd, 2),
                        'upper' => round($sma + 2 * $sd, 2),
                        'lower' => round($sma -2 * $sd, 2),
                    ]
                );
                $bb->save();

                $time = $p->time;
            }
            echo date('Y-m-d H:i:s', $time) . PHP_EOL;
        }

    }

    function generateSd($data, $sma = 0) {
        if (!$sma) {
            $sma = $this->generateSma($data);
        }
        $result = 0;
        $count = 0;
        foreach ($data as $price) {
            $result += pow($price->close - $sma, 2);
            $count ++;
        }

        return round(sqrt($result / $count), 2);
    }

    function generateSma($data) {
        $result = 0;
        $count = 0;
        foreach ($data as $price) {
            $result += $price->close;
            $count ++;
        }
        return round($result / $count, 2);
    }
}
