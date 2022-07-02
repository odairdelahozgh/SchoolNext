<?php
class Resources extends LiteRecord
{
    protected static $table = 'snxt_resources';
    public function _beforeCreate()
    {
        $this->status = 1;
    }
}
