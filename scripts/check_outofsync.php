<?php

set_time_limit(0);
require "../admin/auth.php";

$start = strtotime('2023-12-10');

$orders = func_query("
    SELECT orderid, login, route_id, date FROM dbp_orders where date > {$start} AND login not like '%dbp_an0nym0us%'
");

foreach ($orders as $order) {
    $orderObject = OrderFactory::get_by_orderid($order['orderid']);
    $products = $orderObject->getProducts();

    foreach ($products as $p) {
        if (!empty($p['options']['parentid'])) {
            $recurringOrder = new RecurringOrder($order['login'], $order['route_id']);
            $recurringProduct = $recurringOrder->get_product_by_cartid($p['options']['parentid']);
            if (empty($recurringProduct) || $recurringProduct['productid'] != $p['productid']) {
                echo $order['login'] . ',' . date("Y-m-d", $order['date']) . ',' . $p['product'] . PHP_EOL;

                /*
                if (count($products) === 1) {
                    $orderObject->DeleteStorage();
                    echo "Deleted" . PHP_EOL;
                    die;
                } else {
                    $orderObject->deleteProductByCartId($p['cartid']);
                    $orderObject->calculate_and_save();
                    die;
                }
                */
            }
        }
    }
}
