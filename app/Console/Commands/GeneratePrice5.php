<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Price;
use App\Models\Price5;

class GeneratePrice5 extends Command
{
    protected $signature = 'generate_price5';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generating Price5 Band data from Price';

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

                if ($minute % 5 == 0) {
                    $price5 = Price5::firstOrCreate(
                        ['time' => $p->time],
                        [
                            'high' => $p->high,
                            'low' => $p->low,
                            'open' => $p->open,
                            'close' => $p->close,
                        ]
                    );
                } else {
                    $price5->close = $p->close;

                    if ($price5->low > $p->low) {
                        $price5->low = $p->low;
                    }
                    if ($price5->high < $p->high) {
                        $price5->high = $p->high;
                    }
                }

                if ($minute % 5 == 4) {
                    $price5->save();
                }

                $time = $p->time;
            }
            echo date('Y-m-d H:i:s', $time) . PHP_EOL;
        }

    }
}
