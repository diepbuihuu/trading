<?php
require "../auth.php";

$orderObject = OrderFactory::get_by_orderid(1232249);
$orderObject->save();
