<?php

class User extends MiniEngine_Table
{
    public function init()
    {
        $this->_columns['user_id'] = ['type' => 'serial'];
        $this->_columns['name'] = ['type' => 'varchar', 'size' => 32];
        $this->_columns['created_at'] = ['type' => 'bigint'];
        $this->_columns['is_admin'] = ['type' => 'int', 'default' => 0];
    }
}
