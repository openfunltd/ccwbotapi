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
        return [
            'type' => 'legislator',
            'data' => [
                // TODO: 換成真實資料
                DataBuilder::buildLegislator([
                    'name' => '王金平',
                    'party' => '中國國民黨',
                    'constituency' => '台北市第五選區',
                ]),
            ],
        ];

    }
}
