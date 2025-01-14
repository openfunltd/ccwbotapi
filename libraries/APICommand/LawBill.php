<?php

class APICommand_LawBill extends APICommand
{
    public static $name = '法律對應議案查詢';
    public static $description = '查詢法律對應議案';
    public static $params = [
        '法律名稱',
    ];

    public static function run($params, $user = null)
    {
        $law_id = $params[0];

        $ret = LYAPI::apiQuery("/bills?法律編號={$law_id}&limit=10", "查詢 {$law_id} 議案資訊");
        $data = [];
        foreach ($ret->bills as $bill) {
            unset($bill->相關附件);
            $data[] = DataBuilder::buildBill($bill, $user);
        }
        return [
            'type' => 'bill',
            'data' => $data,
        ];
    }
}
