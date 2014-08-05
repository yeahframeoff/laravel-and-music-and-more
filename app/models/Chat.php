<?php

namespace Karma\Entities;

class Chat extends Eloquent
{
	protected $fillable = array('id', 'description');
    protected $timestamps = false;
    
    public function participants()
    {
        return $this->hasManyThrough('ChatsUser', 'User');
    }
    
    public function messages()
    {
        return $this->belongsToMany('ChatsMessage');
    }
}