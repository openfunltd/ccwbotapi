<?php

include(__DIR__ . '/../init.inc.php');
$ret = LYAPI::apiQuery("/legislators?屆=11", "取得立委名單");

$fp = fopen(__DIR__ . '/../data/legislators.csv', 'w');
fputcsv($fp, ['key']);
foreach ($ret->legislators as $legislator) {
    fputcsv($fp, [$legislator->委員姓名]);
}
fclose($fp);
