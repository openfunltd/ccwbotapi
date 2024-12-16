<?php

class UserAssociate extends MiniEngine_Table
{
    public function init()
    {
        $this->_columns['associate_id'] = ['type' => 'serial'];
        $this->_columns['user_id'] = ['type' => 'int'];
        $this->_columns['source_id'] = ['type' => 'int'];
        $this->_columns['uid'] = ['type' => 'varchar', 'size' => 128];

        $this->_indexes['user_id'] = ['columns' => ['user_id']];
        $this->_indexes['source_uid'] = ['columns' => ['source_id', 'uid'], 'unique' => true];
    }
}
