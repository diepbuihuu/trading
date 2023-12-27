<?php
require "../auth.php";

$start_date = strtotime('2023-02-06');
$sku = 'SKU1851';

$orders = func_query("
select o.orderid
from dbp_orders o
inner join dbp_order_details od
on o.orderid = od.orderid
where
	o.date > unix_timestamp()
AND
	od.productcode = '{$sku}'
");

foreach ($orders as $order) {
	$orderObject = OrderFactory::get_by_orderid($order['orderid']);
	$products = $orderObject->getProducts();

	foreach ($products as $p) {
		if ($p['productcode'] == $sku) {
			moveCurrentProduct($orderObject, $p, $start_date);
		}
	}
}

function moveCurrentProduct($orderObject, $p, $start_date) {
	$routeObject = $orderObject->get_route();
	$next_delivery_date = $routeObject->get_delivery_date($start_date);

	if ($next_delivery_date <= $orderObject->getDate()) {
		return false;
	}

	$can_move = true;
	$newOrderObject = OrderFactory::get($orderObject->getUser(), $orderObject->getRouteId(), 'C', $next_delivery_date);
	$newProducts = $newOrderObject->getProducts();
	foreach ($newProducts as $np) {
		if ($np['productid'] == $p['productid']) {
			$can_move = false;
		}
	}

	if ($can_move) {
		//echo "move current" . PHP_EOL;
		echo $orderObject->getUser() . ',' . $p['productcode'] . ',' . date('Y-m-d', $orderObject->getDate()) . ',' . date('Y-m-d', $next_delivery_date) . PHP_EOL;
		$deleted = $orderObject->deleteProductByCartId($p['cartid']);
		$newOrderObject->addProduct($p, $p['amount']);

		$orderObject->calculate_and_save();
		$newOrderObject->calculate_and_save();
	} else {
		moveCurrentProduct($orderObject, $p, $start_date + 7 * 86400);
	}
}
