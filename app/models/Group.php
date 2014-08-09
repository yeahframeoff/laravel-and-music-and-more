<?php

namespace Karma\Entities;

class Group extends \Eloquent
{
    protected $fillable = array('id', 'founder_id', 'name', 'description', 'avatar', 'active');
    protected $timestamps = false;
    
    public function users()
    {
        return $this->belongsToMany('User');
    }
	
    public function founder()
    {
        return $this->belongsTo('User', 'founder_id');
    }
}