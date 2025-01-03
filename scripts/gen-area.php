<?php

include(__DIR__ . '/../init.inc.php');
$input = fopen('https://gist.githubusercontent.com/ronnywang/e33d25b14ae7b83582372bfe081e0743/raw/3fa78623004766c45931daa41800edd2b53f3d14/legislators.csv', 'r');
$cols = fgetcsv($input);

$output_area = fopen(__DIR__ . '/../data/area.csv', 'w');
$output_zipcode = fopen(__DIR__ . '/../data/zipcode.csv', 'w');
fputcsv($output_area, ['key', 'county', 'name']);
fputcsv($output_zipcode, ['key', 'name']);
while ($rows = fgetcsv($input)) {
    $values = array_combine($cols, $rows);
    if ($values['area_zipcode']) {
        foreach (explode(';', $values['area_zipcode']) as $zipcode) {
            fputcsv($output_zipcode, [$zipcode, $values['name']]);
        }
    }

    if ($values['district']) {
        foreach (explode(';', $values['district']) as $district) {
            if (preg_match('#^...?[鄉鎮市區]$#u', $district)) {
                $district = mb_substr($district, 0, -1);
            }
            fputcsv($output_area, [$district, $values['division'], $values['name']]);
        }
    }
}
fclose($output_zipcode);
fclose($output_area);
