<?php

class DataBuilder
{
    public static function buildLegislator($data)
    {
        $data['actions'] = [];
        $data['actions'][] = [
            'name' => '追蹤立委',
            'method' => 'Follow',
            'params' => ['立委', $data['name']],
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
        return $data;
    }
}
