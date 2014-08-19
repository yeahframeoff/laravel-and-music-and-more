<?php

namespace Karma\Entities;

class ChatsMessage extends \Eloquent
{
    protected $table = 'chat_messages';
    protected $fillable = array('id', 'chat_id', 'from_user_id', 'message');
    
    public function chat()
    {
        return $this->hasOne('Karma\Entities\Chat');
    }
    
    public function sender()
    {
        return $this->hasOne('Karma\Entities\User', 'from_user_id');
    }
}