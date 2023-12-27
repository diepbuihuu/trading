<?php
require "../admin/auth.php";

define('PROCESS_ON_HOLD', true);

$toRestore = [
    ['jhildenbrandt@me.com', 1672246800,1672245650],
    ['brooke@noreply.com', 1673197200,1673207417],
    ['cobblepondsaltamont@kingbrothersdairy.com', 1673197200,1673212126],
    ['madriver28@aol.com', 1676394000,1676392492],
    ['shannon7731018@gmail.com', 1676394000,1676392514],
    ['adam_shroyer', 1676566800,1676564951],
    ['Lksmiles1@msn.com', 1676566800,1676564971],
    ['allison@dunhamsbay.com', 1677776400, 1677764764],
];


foreach ($toRestore as $row) {
    $route_id = func_query_first_cell("select route_id from dbp_users_routes where login = '" . $row[0] . "' LIMIT 1");
    $orderObject = new Order($row[0], $route_id, 'C', $row[1]);
    $products = func_query("select productid, inv_change from dbp_log_inventory where order_date = {$row[1]} AND date >=" . ($row[2] - 1) . " AND date <= " . ($row[2] + 1));

    //var_dump($products);die;
    foreach ($products as $p) {
        $orderObject->addProduct($p, $p['inv_change']);
    }

    $orderObject->calculate_and_save();

    $addedProducts = $orderObject->getProducts();
    echo $row[0] . " / " . date("Y-m-d", $row[1]) . PHP_EOL;
    foreach($addedProducts as $p) {
        echo $p['product'] . ' x ' . $p['amount'] . PHP_EOL;
    }
    echo PHP_EOL;
}
