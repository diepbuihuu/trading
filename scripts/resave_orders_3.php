<?php
require "../auth.php";

$orderids = func_query("select orderid from dbp_coupons_used_temp");

$count = count($orderids);


foreach ($orderids as $index => $row) {

	$orderid = $row['orderid'];

	echo $index . ' / ' . $count . ' : ' . $orderid . PHP_EOL;

	$orderObject = OrderFactory::get_by_orderid($orderid);

	$couponIds = $orderObject->getExtra('coupon_id');

	if ($couponIds) {
		db_query("DELETE FROM dbp_coupons_used where orderid = {$orderid} AND coupon_id NOT IN ({$couponIds})");
	} else {
		db_query("DELETE FROM dbp_coupons_used where orderid = {$orderid}");
	}

	$orderObject->calculate_and_save();

}
