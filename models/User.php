<?php

class UserRow extends MiniEngine_Table_Row
{
    public function follow($type, $key)
    {
        try {
            UserFollow::insert([
                'user_id' => $this->user_id,
                'type' => $type,
                'follow_key' => $key,
                'created_at' => time(),
            ]);
            return true;
        } catch (MiniEngine_Table_DuplicateException $e) {
            return false;
        }
    }

    public function unfollow($type, $key)
    {
    }
}

class User extends MiniEngine_Table
{
    public function init()
    {
        $this->_columns['user_id'] = ['type' => 'serial'];
        $this->_columns['name'] = ['type' => 'varchar', 'size' => 32];
        $this->_columns['created_at'] = ['type' => 'bigint'];
        $this->_columns['is_admin'] = ['type' => 'int', 'default' => 0];

        $this->_relations['follows'] = ['rel' => 'has_many', 'type' => 'UserFollow'];
    }
}
