<?php

class APICommand_Legislator extends APICommand
{
    public static $name = '立委查詢';
    public static $description = '查詢立委資訊';
    public static $params = [
        '立委姓名',
    ];
}
