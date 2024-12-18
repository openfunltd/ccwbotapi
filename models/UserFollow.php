<?php

class UserFollow extends MiniEngine_Table
{
    public static function typeMap()
    {
        return [
            1 => '立委',
            2 => '法律',
            3 => '議題',
        ];
    }

    public function init()
    {
        $this->_columns['follow_id'] = ['type' => 'serial'];
        $this->_columns['user_id'] = ['type' => 'int'];
        // 1-legislator, 2-law, 3-topic
        $this->_columns['type'] = ['type' => 'int'];
        $this->_columns['follow_key'] = ['type' => 'varchar', 'size' => 128];
        $this->_columns['created_at'] = ['type' => 'bigint'];

        $this->_indexes['user_type_key'] = ['columns' => ['user_id', 'type', 'follow_key'], 'unique' => true];
    }
}
