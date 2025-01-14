<?php

class APICommand_TodayMeet extends APICommand
{
    public static $name = '列出今日會議';
    public static $description = '列出今日或是指定日期的會議';
    public static $params = [
        '日期',
    ];

    public static function run($params, $user = null)
    {
        if (!$params[0]) {
            $params[0] = date('Y-m-d');
        } else {
            $params[0] = date('Y-m-d', strtotime($params[0]));
        }
        $ret = LYAPI::apiQuery("/meets/?日期={$params[0]}", "查詢 {$params[0]} 會議資訊");
        if ($ret->error) {
            return [
                'type' => 'text',
                'data' => [
                    'text' => "查無此會議",
                ],
            ];
        }
        $meets = [];
        foreach ($ret->meets as $meet) {
            $meets[] = DataBuilder::buildMeet($meet, $user);
        }
        return [
            'type' => 'meet',
            'data' => $meets,
        ];
    }
}
