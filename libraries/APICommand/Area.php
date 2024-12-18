<?php

class APICommand_Area extends APICommand
{
    public static $name = '選區立委查詢';
    public static $description = '查詢選區立委資訊';
    public static $params = [
        '選區名稱',
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
                DataBuilder::buildLegislator([
                    'name' => '柯建銘',
                    'party' => '民主進步黨',
                    'constituency' => '台北市第六選區',
                ]),
            ],
        ];
    }
}
