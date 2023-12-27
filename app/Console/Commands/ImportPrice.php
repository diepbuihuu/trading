<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Price;

class ImportPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import_price {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Price data from file';

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
        $filename = $this->argument('filename');
        $content = Storage::get($filename);
        $data = json_decode(trim($content), true);
        $size = count($data['t']);

        for ($i = 0; $i < $size; $i++) {
            $price = Price::firstOrCreate(
                ['time' => $data['t'][$i]],
                [
                    'high' => round($data['h'][$i], 2),
                    'low' => round($data['l'][$i], 2),
                    'open' => round($data['o'][$i], 2),
                    'close' => round($data['c'][$i], 2),
                ]
            );
            $price->save();
        }

    }
}
