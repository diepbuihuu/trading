<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Factories\PriceFactory;
use App\Models\Order;

class RunStrategy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run_strategy {strategy_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Strategy';

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
        $strategyID = $this->argument('strategy_id');

        $startTime = strtotime('2023-08-20');
        $endTime = strtotime('2023-09-14');
        $currentTime = $startTime;
        $dataLength = PriceFactory::DATA_LENGTH;
        PriceFactory::setStartTime($startTime);

        $strategy = $this->getStrategy($strategyID);
        $hasOrder = false;

        while ($currentTime <= $endTime) {
            $lastData = PriceFactory::shift();
            $currentPrice = $lastData[$dataLength - 1];
            $currentTime = $currentPrice->time;
            $strategy->update();

            if (!$hasOrder) {
                if ($strategy->canSell()) {
                    $order = Order::sell($strategyID, $strategy->getOpenTime(), $strategy->getPrice());
                    $order->setTakeProfit($strategy->getTakeProfit());
                    $order->setStopLoss($strategy->getStopLoss());
                    $hasOrder = true;
                } else if ($strategy->canBuy()) {
                    $order = Order::buy($strategyID, $strategy->getOpenTime(), $strategy->getPrice());
                    $order->setTakeProfit($strategy->getTakeProfit());
                    $order->setStopLoss($strategy->getStopLoss());
                    $hasOrder = true;
                }

            } else {
                if ($order->isStopLoss($currentPrice) || $order->isTakeProfit($currentPrice)) {
                    $hasOrder = false;

                } else if ($strategy->shouldCloseOrder()) {
                    $order->close($currentTime, $strategy->getClosePrice());
                    $hasOrder = false;

                } else if($strategy->shouldChangeStopLoss()) {
                    $order->setStopLoss($strategy->getStopLoss());

                } else if($strategy->shouldChangeTakeProfit()) {
                    $order->setTakeProfit($strategy->getTakeProfit());
                }
            }

        }
    }

    public function getStrategy($strategyID) {
        switch ($strategyID) {
            case '1':
                return new \App\Strategies\Strategy1();
            default:
                return \App\Strategies\Strategy::getStrategy($strategyID);
        }
    }
}
