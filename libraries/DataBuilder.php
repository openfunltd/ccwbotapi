<?php

class DataBuilder
{
    public static function buildLegislator($data)
    {
        $data->actions = [];
        $data->actions[] = [
            'name' => '追蹤立委',
            'method' => 'Follow',
            'params' => ['立委', $data->立委姓名],
        ];
        return $data;
    }

    public static function buildLaw($data)
    {
        $data['actions'] = [];
        $data['actions'][] = [
            'name' => '追蹤法律',
            'method' => 'Follow',
            'params' => ['法律', $data['law_id']],
        ];
        $data['actions'][] = [
            'name' => '關聯議案',
            'method' => 'LawBill',
            'params' => [$data['law_id']],
        ];
        return $data;
    }

    public static function buildBill($data)
    {
        $data['actions'] = [];
        $data['actions'][] = [
            'name' => '原始資料',
            'method' => '_link',
            'link' => "https://ppg.ly.gov.tw/ppg/bills/{$data['billNo']}/details",
        ];
        foreach ($data['laws'] ?? [] as $law_id => $law_name) {
            $data['actions'][] = [
                'name' => "查看法律 {$law_name}",
                'method' => 'Law',
                'params' => [$law_id],
            ];
        }
        return $data;
    }
}
