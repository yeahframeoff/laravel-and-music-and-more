<?php

namespace Karma\Entities;

class Chat extends \Eloquent
{
	protected $fillable = array('id', 'description');
    public $timestamps = false;
    
    public function participants()
    {
        return $this->belongsToMany('User');
    }
    
    public function messages()
    {
        return $this->hasMany('ChatMessage');
    }
}