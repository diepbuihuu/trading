<?php
require "../auth.php";

$products = func_query("select t.productid, t.image_path, p.product from dbp_thumbnails t inner join dbp_products p on t.productid = p.productid where p.forsale = 'Y'");

foreach ($products as $p) {
    $fullpath = "/var/www/html" . $p['image_path'];
    if (!file_exists($fullpath)) {
        echo $p['productid'] . ',' . $p['product'] . ',' . $p['image_path'] . PHP_EOL;
    }
}
