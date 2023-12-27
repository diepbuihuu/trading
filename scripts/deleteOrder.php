<?php
require "../auth.php";

$orders = func_query("select o.orderid, o.date, o.login, r.route_name from dbp_orders o inner join dbp_routes r on o.route_id = r.route_id inner join dbp_route_vacations rv on rv.route_id = o.route_id and rv.start_date < o.date and rv.end_date > o.date where o.date > unix_timestamp()");

foreach ($orders as $o) {
    echo $o['login'] . ',' . date('Y-m-d', $o['date']) . ',"' . $o['route_name'] . '"'  . PHP_EOL;
    //$current_order = new \CurrentOrder($o['orderid']);
    //$current_order->DeleteStorage();
}
