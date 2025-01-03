<?php

class DataBuilder
{
    public static function buildMeet($data)
    {
        $data->actions = [];
        if ($data->會議資料 ?? false) {
            $data->actions[] = [
                'name' => '原始資料',
                'method' => '_link',
                'link' => $data->會議資料[0]->ppg_url,
            ];
        }
        return $data;
    }

    public static function buildIVOD($data)
    {
        $data->actions = [];
        $data->actions[] = [
            'name' => '原始資料',
            'method' => '_link',
            'link' => $data->IVOD_URL,
        ];
        return $data;
    }

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
        $data->actions = [];
        $data->actions[] = [
            'name' => '追蹤法律',
            'method' => 'Follow',
            'params' => ['法律', $data->法律編號],
        ];
        $data->actions[] = [
            'name' => '關聯議案',
            'method' => 'LawBill',
            'params' => [$data->法律編號],
        ];
        return $data;
    }

    public static function buildBill($data)
    {
        $data->actions = [];
        $data->actions[] = [
            'name' => '原始資料',
            'method' => '_link',
            'link' => "https://ppg.ly.gov.tw/ppg/bills/{$data->議案編號}/details",
        ];
        foreach (array_combine($data->法律編號 ?? [], $data->{'法律編號:str'} ?? []) as $law_id => $law_name) {
            $data->actions[] = [
                'name' => "查看法律 {$law_name}",
                'method' => 'Law',
                'params' => [$law_id],
            ];
        }
        return $data;
    }
}
