<?php
require "../admin/auth.php";

$start = func_get_week_start();

$users = func_query("
select
o.login, o.orderid, cu.coupon_id
from dbp_orders o
inner join dbp_coupons_used cu
on o.orderid = cu.orderid
where o.date > {$start}
AND o.orderid = 3989;
");

foreach ($users as $user) {
	$orderObject = OrderFactory::get_by_orderid($user['orderid']);

	$coupon = new Coupon($orderObject->getUser(), $user['coupon_id']);
	if ($coupon->get_type() == 'F') {
		if (!$coupon->can_apply_to_order($orderObject)) {
			if ($coupon->get_error_message() == 'COUPON_TO_NTH_ORDER_ONLY') {
				echo $user['orderid'] . ' ' . $coupon->get_name() . PHP_EOL;
				$orderObject->remove_coupon($coupon, true);
				$orderObject->calculate_and_save();
			}
		}

		//$orderObject->remove_coupon($coupon, true);
		//$orderObject->calculate_and_save();
	}


}
