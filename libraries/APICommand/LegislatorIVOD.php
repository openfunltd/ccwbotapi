<?php

class APICommand_LegislatorIVOD extends APICommand
{
    public static $name = '立委影片查詢';
    public static $description = '查詢立委最近影片';
    public static $params = [
        '委員姓名',
    ];

    public static function run($params, $user = null)
    {
        $name = $params[0];

        $ret = LYAPI::apiQuery("/ivods/?limit=10&委員名稱=" . urlencode($name), "查詢 {$name} 立委影片資訊");
        if ($ret->error or count($ret->ivods) == 0) {
            return [
                'type' => 'text',
                'data' => [
                    'text' => "查無此立委",
                ],
            ];
        }

        return [
            'type' => 'ivod',
            'data' => array_map(['DataBuilder', 'buildIVOD'], $ret->ivods),
        ];

    }
}
