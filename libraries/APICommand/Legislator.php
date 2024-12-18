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
        return "TODO: 回傳 {$params[0]} 立委的相關資料";
    }
}
