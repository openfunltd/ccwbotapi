<?php

class APICommand_Unfollow extends APICommand
{
    public static $name = '取消追蹤功能';
    public static $description = '取消追蹤';
    public static $params = [
        '類別',
        '值',
    ];
    public static $need_login = true;

    public static function run($params, $user = null)
    {
        $type = $params[0];
        $value = $params[1];

        // TODO: 檢查是否 $value 是合法的（不要亂追蹤不存在的法律或立委）
        if ($type == '立委') {
            $ret = $user->unfollow(1, $value);
        } elseif ($type == '法律') {
            $ret = $user->unfollow(2, $value);
        } elseif ($type == '議題') {
            $ret = $user->unfollow(3, $value);
        }

        if ($ret) {
            return "TODO: {$user->name} 成功取消追蹤 {$type} {$value}";
        } else {
            return "TODO: {$user->name} 已經追蹤過 {$type} {$value}";
        }
    }
}
