<?php

set_time_limit(0);
require "../admin/auth.php";

//$config['General']['nearest_orders_number'] = 3;
//AND r.route_id IN (25, 36, 37, 55, 73, 77)
$start = strtotime('2024-01-08');
$end = strtotime('2024-01-09');

$users = func_query("SELECT
	c.login, ro.route_id, ro.recurring_order
	FROM $sql_tbl[recurring_orders] ro
	inner join $sql_tbl[customers] c
	ON c.login = ro.login
	INNER JOIN dbp_routes r on ro.route_id = r.route_id
	INNER JOIN dbp_users_routes ur on ro.login = ur.login AND ro.route_id = ur.route_id
	WHERE c.user_active = 'Y' AND recurring_order NOT LIKE '%a:3:{s:8:\"products\";a:0%'
	AND r.route_id IN (15,26,27,28,37)
	ORDER BY c.login");
$total = count($users);
$count = 0;

foreach($users as $u) {
	$user = $u['login'];
	$route_id = $u['route_id'];
	$count ++;

	$recurring_order = unserialize($u['recurring_order']);
	$count_recurring = count($recurring_order['products']);

	$existing_order = func_query_first_cell("SELECT orderid FROM dbp_orders WHERE login = '{$u['login']}' AND date > {$start} AND date < {$end}");


	if (!$existing_order && $count_recurring > 0) {
		echo $count . "/" . $total . "Syncing for $user, $route_id\n";
		die;
		$summary = new Summary($user, 'R', $route_id);
		$summary->sync(false, 0, false, null, [$start, $end], [$route_id]);
		$summary->__destruct();
		unset($summary);
		die;
	}

	//die;
}
