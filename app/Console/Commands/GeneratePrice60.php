<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Price;
use App\Models\Price60;

class GeneratePrice60 extends Command
{
    protected $signature = 'generate_price60';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generating Price60 Band data from Price';

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
            $prices = Price::where('time', '>', $time)->orderBy('time')->take(100)->get();
            if (count($prices) === 0) {
                break;
            }

            foreach ($prices as $p) {
                $minute = round($p->time / 60, 0);

                if ($minute % 60 == 0) {
                    $price60 = Price60::firstOrCreate(
                        ['time' => $p->time],
                        [
                            'high' => $p->high,
                            'low' => $p->low,
                            'open' => $p->open,
                            'close' => $p->close,
                        ]
                    );
                } else {
                    $price60->close = $p->close;

                    if ($price60->low > $p->low) {
                        $price60->low = $p->low;
                    }
                    if ($price60->high < $p->high) {
                        $price60->high = $p->high;
                    }
                }

                if ($minute % 60 == 59) {
                    $price60->save();
                }

                $time = $p->time;
            }
            echo date('Y-m-d H:i:s', $time) . PHP_EOL;
        }

    }

}
