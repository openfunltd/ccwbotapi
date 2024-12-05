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
}
