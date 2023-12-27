<?php
require "../auth.php";

$customers = func_query(
    "
    SELECT
        c.login,u.info
    FROM
        dbp_customers c
    INNER JOIN
        dbp_user_info u
    ON
        c.login = u.login
    WHERE
        c.usertype = 'C'
    AND c.login = 'courtneygamble52@yahoo.com'
    "
);

foreach ($customers as $c) {
    $extra = unserialize($c['info']);
    if (!empty($extra['last_order_edit'])) {
        db_query_builder()->array2update('customers', [
                'last_order_changed' => $extra['last_order_edit']
            ])
            ->where('login = :login')
            ->setParameter('login', $c['login'])
            ->execute();
    }
}
