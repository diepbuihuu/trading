<?php
require "../auth.php";

$start_date = strtotime('2022-01-01');
$end_date = strtotime('2022-12-31');

$orders = func_query("
select o.login, od.product, sum(od.amount) as amount
from dbp_orders o
inner join dbp_order_details od
on o.orderid = od.orderid
where
	o.date > {$start_date} AND o.date < {$end_date}
AND
	o.status = 'C'
AND
	od.amount > 0
AND
	od.options not like '%master_cartid%'
GROUP by o.login, od.productid
ORDER by o.login, od.productid
");

tableToCsv('orders.csv', $orders, ["login", "product", "amount"]);

function tableToCsv($filename, $table, $columns) {
	file_put_contents($filename, implode(',', $columns) . PHP_EOL, FILE_APPEND);
	foreach ($table as $row) {
		$csv_data = [];
		foreach ($columns as $c) {
			$csv_data[] = '"' . str_replace('"', '', $row[$c]) . '"';
		}
		file_put_contents($filename, implode(',', $csv_data) . PHP_EOL, FILE_APPEND);
	}
}
