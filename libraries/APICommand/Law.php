<?php

class APICommand_Law extends APICommand
{
    public static $name = '法律查詢';
    public static $description = '查詢法律相關資訊';
    public static $params = [
        '法律名稱',
    ];

    public static function run($params, $user = null)
    {
        return [
            'type' => 'law',
            'data' => [
                // TODO: 換成真實資料
                DataBuilder::buildLaw([
                    'name' => '兒童及少年性剝削防制條例',
                    'law_id' => '01234',
                    'status' => '現行',
                    'version' => '2024-07-12-修正',
                ]),
            ],
        ];
    }
}
