<?php
require "../auth.php";

$orders = [
11857,
11863,
11865,
11866,
11867,
11870,
11872,
11873,
11874,
11876,
11877,
11879,
11881,
11886,
11889,
11890,
11892,
11893,
11896,
11902,
11905,
11925
];
foreach ($orders as $o) {
    echo $o . PHP_EOL;
    $current_order = new \CurrentOrder($o);
    $current_order->deleteProductByProductId(1655);
    $current_order->calculate_and_save();
    break;
}
