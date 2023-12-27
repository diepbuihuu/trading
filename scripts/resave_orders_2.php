<?php
require "../auth.php";

$start_date = strtotime('2023-08-14');
$end_date = strtotime('2023-08-15');


$orders = func_query("
select o.orderid, o.date
from dbp_orders o
where
	o.date > {$start_date}
AND
	o.date < {$end_date}
ORDER BY
    o.date ASC
");

foreach ($orders as $order) {
    echo date('Y-m-d', $order['date']);
	$orderObject = OrderFactory::get_by_orderid($order['orderid']);
	$orderObject->save();
}
