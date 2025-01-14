<?php

class UserRow extends MiniEngine_Table_Row
{
    protected static $_follow_map = [];

    public function isFollow($type, $key)
    {
        if (!array_key_exists($this->user_id, self::$_follow_map)) {
            self::$_follow_map[$this->user_id] = [];
            foreach ($this->follows as $follow) {
                self::$_follow_map[$this->user_id][$follow->type . ':' . $follow->follow_key] = true;
            }
        }
        return self::$_follow_map[$this->user_id][$type . ':' . $key] ?? false;
    }

    public function follow($type, $key)
    {
        try {
            UserFollow::insert([
                'user_id' => $this->user_id,
                'type' => $type,
                'follow_key' => $key,
                'created_at' => time(),
            ]);
            unset(self::$_follow_map[$this->user_id]);
            return true;
        } catch (MiniEngine_Table_DuplicateException $e) {
            return false;
        }
    }

    public function unfollow($type, $key)
    {
        foreach (UserFollow::search([
            'user_id' => $this->user_id,
            'type' => $type,
            'follow_key' => $key,
        ]) as $follow) {
            $follow->delete();
        }
        unset(self::$_follow_map[$this->user_id]);
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
