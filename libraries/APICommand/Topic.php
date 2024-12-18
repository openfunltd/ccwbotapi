<?php

class APICommand_Topic extends APICommand
{
    public static $name = '議題列表';
    public static $description = '列出可追蹤的議題列表';
    public static $params = [];

    public static function run($params, $user = null)
    {
        return [
            'type' => 'topic',
            'data' => [
                '環保', '教育', '醫療', '交通', '經濟', '社會', '文化', '科技', '國防', '外交',
            ],
        ];
    }
}
