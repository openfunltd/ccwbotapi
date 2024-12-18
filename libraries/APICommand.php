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

    public static function isNeedLogin()
    {
        return static::$need_login ?? false;
    }

    public static function run($params, $user = null)
    {
        return "Not implemented : " . json_encode($params, JSON_UNESCAPED_UNICODE);
    }

    public static function getUserByToken($token, $auto_create = false)
    {
        if (!$token) {
            return false;
        }
        list($source, $uid, $name, $timestamp, $nonce, $sig) = array_map('urldecode', explode('&', $token));
        $config = self::getSourceConfig();
        if (!isset($config[$source])) {
            throw new Exception("Source not found: {$source}");
        }
        if (time() - $timestamp > 300) {
            throw new Exception("Token expired: {$timestamp}");
        }
        // TODO: check nonce
        $secret = $config[$source]->secret;
        $terms = array_map('urldecode', explode('&', $token));
        array_pop($terms);
        if ($sig != crc32($secret . implode('', $terms))) {
            throw new Exception("Invalid signature: {$sig}");
        }
        $source_id = $config[$source]->source_id;
        if ($assoc = UserAssociate::search(['source_id' => $source_id, 'uid' => $uid])->first()) {
            $user = $assoc->user;
            if ($user->name != $name) {
                $user->name = $name;
                $user->save();
            }
            return $user;
        }
        if (!$auto_create) {
            return false;
        }
        $user = User::insert([
            'name' => $name,
            'created_at' => time(),
        ]);
        UserAssociate::insert([
            'source_id' => $source_id,
            'uid' => $uid,
            'user_id' => $user->user_id,
        ]);
        return $user;
    }

    public static function getSourceConfig()
    {
        $env = getenv('SUPPORT_SOURCE');
        if (trim($env) == '') {
            return [];
        }
        $records = [];
        foreach (explode('&', $env) as $config) {
            list($source, $id, $secret) = explode(':', $config);
            $record = new StdClass;
            $record->source = $source;
            $record->source_id = $id;
            $record->secret = $secret;
            $records[$source] = $record;
        }
        return $records;
    }

    public static function query($id, $params, $token = null)
    {
        $class = "APICommand_{$id}";
        if (!class_exists($class)) {
            throw new Exception("APICommand not found: {$id}");
        }
        $ret = new StdClass;
        $ret->id = $id;
        $ret->params = $params;
        $need_login = call_user_func([$class, 'isNeedLogin']);
        $user = self::getUserByToken($token, $need_login);
        if ($need_login && !$user) {
            $ret->error = '需要登入';
            return $ret;
        }
        $result = call_user_func([$class, 'run'], $params, $user);
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
