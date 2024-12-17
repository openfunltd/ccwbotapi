<?php

class APICommand_Follow extends APICommand
{
    public static $name = '追蹤功能';
    public static $description = '追蹤';
    public static $params = [
        '類別',
        '值',
    ];
    public static $need_login = true;

    public static function run($params)
    {
        $type = $params[0];
        $value = $params[1];

        return "TODO: 追蹤 {$type} {$value}";
    }
}
