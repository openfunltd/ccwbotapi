<?php

include(__DIR__ . '/../init.inc.php');
$ret = LYAPI::apiQuery("/laws?類別=母法", "取得法律名單");

$fp = fopen(__DIR__ . '/../data/laws.csv', 'w');
fputcsv($fp, ['key', '代碼', '全名']);
foreach ($ret->laws as $law) {
    fputcsv($fp, [$law->名稱, $law->法律編號, $law->名稱]);
    foreach ($law->其他名稱 as $n) {
        fputcsv($fp, [$n, $law->法律編號, $law->名稱]);
    }
    foreach ($law->別名 as $n) {
        fputcsv($fp, [$n, $law->法律編號, $law->名稱]);
    }
}
fclose($fp);
