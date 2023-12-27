<?php
require "../auth.php";

$users = func_query(
    "
    select
        email
    from
        dbp_customers c
    where
        c.usertype = 'C'
    and
        c.user_active = 'Y'
    and
        not exists (select * from dbp_newslist_subscription nls where nls.listid = 3 and nls.email = c.email)
    "
);

foreach ($users as $u) {

    $insertData = [
        'listid' => 3,
        'email' => $u['email'],
        'since_date' => time()
    ];

    db_query_builder()->array2insert(
        'dbp_newslist_subscription',
        $insertData
    );
}
