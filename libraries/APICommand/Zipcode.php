<?php

class APICommand_Zipcode extends APICommand
{
    public static $name = '郵遞區號查詢';
    public static $description = '查詢選區立委資訊';
    public static $params = [
        '三碼郵遞區號',
    ];

    public static function run($params, $user = null)
    {
        $matches = DataHelper::matchData('zipcode', $params[0]);
        $api_url = "/legislators?屆=11";
        $terms = [];

        if (!$matches['results']) {
            return [
                'type' => 'text',
                'data' => [
                    'text' => "查無此郵遞區號",
                ],
            ];
        }
        foreach ($matches['results'] as $result) {
            $terms[] = "委員姓名=" . urlencode($result['name']);
        }
        $legislators = LYAPI::apiQuery($api_url . '&' . implode('&', $terms), "查詢選區立委資訊");
        if ($legislators->error) {
            return [
                'type' => 'text',
                'data' => [
                    'text' => "查無此立委",
                ],
            ];
        }
        $data = [];
        foreach ($legislators->legislators as $legislator) {
            $data[] = DataBuilder::buildLegislator($legislator);
        }
        return [
            'type' => 'legislator',
            'data' => $data,
        ];
    }
}
