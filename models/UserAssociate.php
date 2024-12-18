<?php

class UserAssociate extends MiniEngine_Table
{
    public static function getSourceMap()
    {
        $map = [
            'google' => 1,
        ];
        foreach (APICommand::getSourceConfig() as $source => $config) {
            $map[$source] = $config->source_id;
        }

        return $map;
    }

    public static function getSourceName($id)
    {
        $map = array_flip(self::getSourceMap());
        if (isset($map[$id])) {
            return $map[$id];
        }
        throw new Exception('Invalid source id: ' . $id);
    }

    public static function getSourceId($source)
    {
        $map = self::getSourceMap();
        if (isset($map[$source])) {
            return $map[$source];
        }
        throw new Exception('Invalid source: ' . $source);
    }

    public function init()
    {
        $this->_columns['associate_id'] = ['type' => 'serial'];
        $this->_columns['user_id'] = ['type' => 'int'];
        $this->_columns['source_id'] = ['type' => 'int'];
        $this->_columns['uid'] = ['type' => 'varchar', 'size' => 128];

        $this->_indexes['user_id'] = ['columns' => ['user_id']];
        $this->_indexes['source_uid'] = ['columns' => ['source_id', 'uid'], 'unique' => true];

        $this->_relations['user'] = ['rel' => 'has_one', 'type' => 'User', 'foreign_key' => 'user_id'];
    }
}
