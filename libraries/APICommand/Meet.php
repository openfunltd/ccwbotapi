<?php

class APICommand_Meet extends APICommand
{
    public static $name = '會議查詢';
    public static $description = '查詢特定會議資料';
    public static $params = [
        '會議代碼',
    ];

    public static function run($params, $user = null)
    {
        $ret = LYAPI::apiQuery("/meets/{$params[0]}", "查詢 {$params[0]} 會議資訊");
        if ($ret->error) {
            return [
                'type' => 'text',
                'data' => [
                    'text' => "查無此會議",
                ],
            ];
        
        }
        return [
            'type' => 'meet',
            'data' => [
                DataBuilder::buildMeet($ret->data, $user),
            ],
        ];
    }
}
