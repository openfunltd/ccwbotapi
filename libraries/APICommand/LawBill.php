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
        return [
            'type' => 'bill',
            'data' => [
                // TODO: 換成真實資料
                DataBuilder::buildBill([
                    'name' => '勞動基準法修正草案',
                    'proposed_by' => '張雅玲',
                    'bill_id' => '20委11007992',
                    'billNo' => '202103109320000',
                    'status' => '交付審查',
                    'laws' => [
                        '04502' => '勞動基準法',
                    ],
                ]),
            ],
        ];
    }
}
