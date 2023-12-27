<?php
require "../auth.php";

$row = 1;
if (($handle = fopen("products.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);

        $url = $data[0];
        $title = db_escape($data[3]);
        $desc = db_escape($data[5]);

        $url = str_replace("https://goodfood2u.ca/", "", $url);
        $url = str_replace("'", "", $url);

        $productid = func_query_first_cell("select productid from dbp_product_extras where name='clean_url' AND value='{$url}'");
        if ($productid) {
            echo $productid . PHP_EOL . $title . PHP_EOL . $desc . PHP_EOL;
            //break;

            db_query("DELETE FROM dbp_product_extras where productid = {$productid} AND name = 'meta_title'");
            db_query("DELETE FROM dbp_product_extras where productid = {$productid} AND name = 'meta_description'");

            db_query("INSERT INTO dbp_product_extras(productid, name, value) VALUES ({$productid}, 'meta_title', '{$title}')");
            db_query("INSERT INTO dbp_product_extras(productid, name, value) VALUES ({$productid}, 'meta_description', '{$desc}')");
            //break;
        } else {
            echo "Product not found " . $url . PHP_EOL;
        }

    }
    fclose($handle);
}
?>
