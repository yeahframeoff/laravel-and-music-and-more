<?php

class ChatsUser extends Eloquent
{
    protected $table = "chat_users";
    protected $fillable = array('id', 'chat_id', 'user_id');
    protected $timestamps = false;
}