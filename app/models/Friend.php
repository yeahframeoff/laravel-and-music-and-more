<?php

class Friend extends \Eloquent
{
    protected $fillable = array('id', 'user_id', 'friend_id', 'confirmed');
    
    
}