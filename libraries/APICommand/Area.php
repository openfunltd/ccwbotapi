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
        $matches = DataHelper::matchData('area', $params[0]);
        $api_url = "/legislators?屆=11";
        $terms = [];

        if (!$matches['results']) {
            return [
                'type' => 'text',
                'data' => [
                    'text' => "查無此選區",
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
            $data[] = DataBuilder::buildLegislator($legislator, $user);
        }
        return [
            'type' => 'legislator',
            'data' => $data,
        ];
    }
}
