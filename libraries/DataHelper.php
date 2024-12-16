<?php

class DataHelper
{
    protected static $_data_cache = [];

    public static function loadData($set)
    {
        $target = __DIR__ . "/../data/{$set}.csv";
        if (!file_exists($target)) {
            throw new Exception("Data file not found: {$set}");
        }
        if (array_key_exists($set, static::$_data_cache)) {
            return;
        }
        $fp = fopen($target, 'r');
        $cols = fgetcsv($fp);
        if (!in_array('key', $cols)) {
            throw new Exception("Data file must have a 'key' column: {$set}");
        }
        static::$_data_cache[$set] = [];
        while ($rows = fgetcsv($fp)) {
            $values = array_combine($cols, $rows);
            $key = $values['key'];
            if (!array_key_exists($key, static::$_data_cache[$set])) {
                static::$_data_cache[$set][$key] = [];
            }
            self::$_data_cache[$set][$key][] = $values;
        }
    }

    public static function searchData($set, $query)
    {
        self::loadData($set);
        $results = [];
        foreach (self::$_data_cache[$set] as $key => $rows) {
            foreach ($rows as $row) {
                if (strpos($row['key'], $query) !== false) {
                    $results[] = $row;
                }
            }
        }
        return $results;
    }

    public static function listDataKeys($set)
    {
        self::loadData($set);
        return array_keys(self::$_data_cache[$set]);
    }

    public static function matchData($set, $text)
    {
        $keys = self::listDataKeys($set);
        $matches = [
            'set' => $set,
            'keys' => [],
            'results' => [],
        ];
        foreach ($keys as $key) {
            if (strpos($text, $key) !== false) {
                $matches['keys'][] = $key;
                $matches['results'] = array_merge($matches['results'], self::$_data_cache[$set][$key]);
            }
        }
        $matches['keys'] = array_values(array_unique($matches['keys']));
        return $matches;
    }
}
