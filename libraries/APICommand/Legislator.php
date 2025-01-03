<?php

class APICommand_Legislator extends APICommand
{
    public static $name = '立委查詢';
    public static $description = '查詢立委資訊';
    public static $params = [
        '立委姓名',
    ];

    public static function run($params, $user = null)
    {
        $name = $params[0];

        $legislator = LYAPI::apiQuery("/legislator/11/{$name}", "查詢 {$name} 立委資訊");
        if ($legislator->error) {
            return [
                'type' => 'text',
                'data' => [
                    'text' => "查無此立委",
                ],
            ];
        
        }
        return [
            'type' => 'legislator',
            'data' => [
                DataBuilder::buildLegislator($legislator->data),
            ],
        ];

    }
}
