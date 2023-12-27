<?php
require "../auth.php";


$blacklist = [17168702010,
15857273447,
13154306020,
17165234702,
17163529140,
17162459344,
17163616975,
15858138476,
17169901713,
15187281071,
17169136044,
17165784542,
17165530692,
15035597495,
16462036990,
17169123977,
17169071818,
15165286381,
17164490136,
17163270747,
17164400397,
17165414816,
17169086422,
17165298831,
17165457945,
18167211357,
17165333685,
17166795466,
17165986161,
17164914088,
16073169487,
17166332541,
19085282537,
17168617157,
17164808227,
15853298406,
17167134007,
16072221401,
17168610515,
17162397995,
15852810067,
15855071677,
17168804607,
17038356450,
17168807049,
17164401005,
17169135998,
17169836197,
17164448709,
17164722722,
17165723738,
17164799800,
17166289488,
17167127948,
17162286482,
17168071439,
17162282197,
17165533909,
17169087955,
17165800719,
16193138340,
17164407183,
17163190730,
14842947419,
17163481921,
13153956887,
17163484638,
17165253567,
17169833239,
17165122818,
17162281077,
17165539899,
17169490517,
15855070951,
17165743264,
19178065880,
17168800741,
17168611198,
17167830837,
17165128075,
17164653885,
13193315214,
17169840344,
17165233434,
15858316168,
17169497912,
17164953205,
13074601778,
17169133299,
15854698991,
17169136043,
17163358151,
17168668566,
17165047635,
15857552918,
17169097177,
17167253639,
17168687969,
19144198052,
17169462732,
17169089947,
15186052483,
15854029282,
17169038559,
17162890634,
17166096575,
17167770024,
14842239238,
17164306997,
17164714917,
17164658356,
17164203258,
17163084767,
15188590449,
17162559282,
16077607526,
17162884394,
17162075466,
17166031202,
17166026947,
14436420108,
17166021208,
17165176457,
17163451605,
17164627025,
13123617370,
17164959093,
17406292045,
17169122934,
16302904384,
17162289096,
18573303942,
17163168536,
17146513976,
17164407988,
17162284033,
17165343019,
18184818794,
17165982219,
18286066330,
15859671023,
17169844951,
17168636174,
17165977689,
17168674268,
17169973313,
17164184156,
17166178694,
17169130234,
17163197440,
17164659125,
17165700642,
17165365606,
19194915489,
17169464387,
17164440637,
17164658568,
15515792430,
17167135310,
17162009820,
17168701263,
17164279164,
17164281555,
17169015804,
17164350307,
15853311510,
17167136579,
17165647017,
17163742707,
17162086107,
17163385105,
17162570222,
19038559120,
17169849086,
13153080608,
17169233893];

$users = func_query(
    "select login, phone from dbp_customers where usertype = 'C' and user_active = 'Y'"
);

db_query("delete from dbp_register_field_values where fieldid = 2");

foreach ($users as $u) {
    $phone = "1" . preg_replace("/[^0-9]/", "", $u["phone"]);
    $insertData = [
        'fieldid' => 2,
        'login' => $u['login'],
        'value' => 'Y'
    ];
    if (in_array($phone, $blacklist)) {
        echo $u["login"] . PHP_EOL;
        $insertData['value'] = '';
    }

    db_query_builder()->array2insert(
        'register_field_values',
        $insertData
    );
}
