<?php

namespace Karma\Entities;

class ChatsMessage extends \Eloquent
{
    protected $table = 'chat_messages';
    protected $fillable = array('id', 'chat_id', 'from_user_id', 'message');
    
    public function chat()
    {
        return $this->hasOne('Chat');
    }
    
    public function sender()
    {
        return $this->hasOne('User', 'from_user_id');
    }
}