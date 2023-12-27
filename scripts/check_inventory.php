<?php
require "../auth.php";

$start = strtotime('Tomorrow 00:00');
$end = func_get_x_inventory_days();

$sql = "SELECT
            productid, sum(amount) as amount
        FROM
            dbp_order_details od
        INNER JOIN
            dbp_orders o
        ON
            od.orderid = o.orderid
        WHERE
            o.date > {$start} AND o.date < {$end}
        GROUP BY
            od.productid
        ";
$products = func_query($sql);

foreach ($products as $p) {
    $total = func_query_first_cell("SELECT avail from dbp_products where productid = {$p['productid']}");
    $today = func_query_first_cell("SELECT avail from dbp_inventory where productid = {$p['productid']}");
    if ($today - $total != $p['amount']) {
        echo $p['productid'] . ' ' . $total . ' ' . $today . ' ' . $p['amount'] . PHP_EOL;
    }
}
