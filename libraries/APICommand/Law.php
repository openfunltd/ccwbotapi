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
        $law_id = $params[0];

        $law = LYAPI::apiQuery("/laws/{$law_id}", "查詢 {$law_id} 法律資訊");

        return [
            'type' => 'law',
            'data' => [
                DataBuilder::buildLaw($law->data),
            ],
        ];
    }
}
