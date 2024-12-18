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
}
