<?php

class APICommand_Area extends APICommand
{
    public static $name = '選區立委查詢';
    public static $description = '查詢選區立委資訊';
    public static $params = [
        '選區名稱',
    ];

    public static function run($params)
    {
        return 'TODO: 選區查詢';
    }
}
