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

    public static function query($id, $params)
    {
        $class = "APICommand_{$id}";
        if (!class_exists($class)) {
            throw new Exception("APICommand not found: {$id}");
        }
        $ret = new StdClass;
        $ret->id = $id;
        $ret->params = $params;
        $result = call_user_func([$class, 'run'], $params);
        if (!property_exists($result, 'result')) {
            $ret->result = $result;
        } else {
            foreach ($result as $k => $v) {
                $ret->$k = $v;
            }
        }
        return $ret;
    }
}
