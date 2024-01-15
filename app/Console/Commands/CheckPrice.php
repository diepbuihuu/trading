<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Price;

class CheckPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check_price {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Price on file';

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

        for ($i = 0; $i < $size - 1; $i++) {
            $timeDiff = $data['t'][$i + 1] - $data['t'][$i];
            if ($timeDiff != 60) {
                echo date('Y-m-d H:i:s', $data['t'][$i]) . ' ' . $timeDiff . PHP_EOL;
            }
        }

    }
}
