<?php

namespace Karma\Entities;

class Chat extends \Eloquent
{
	protected $fillable = array('id', 'description');
    public $timestamps = false;
    
    public function participants()
    {
        return $this->belongsToMany('Karma\Entities\User');
    }
    
    public function messages()
    {
        return $this->hasMany('Karma\Entities\ChatMessage');
    }
}