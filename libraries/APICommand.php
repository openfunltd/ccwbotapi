<?php

class APICommand
{
    public static function getName()
    {
        return static::$name;
    }

    public static function getDescription()
    {
        return static::$description;
    }

    public static function getParams()
    {
        return static::$params;
    }

    public static function run($params)
    {
        return "Not implemented : " . json_encode($params, JSON_UNESCAPED_UNICODE);
    }
}
