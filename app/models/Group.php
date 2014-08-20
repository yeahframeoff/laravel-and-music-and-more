<?php

namespace Karma\Entities;

class Group extends \Eloquent
{
    protected $fillable = array('id', 'founder_id', 'name', 'description', 'avatar', 'active');
    public $timestamps = false;
    
    public function users()
    {
        return $this->belongsToMany('Karma\Entities\User');
    }
	
    public function founder()
    {
        return $this->belongsTo('Karma\Entities\User', 'founder_id');
    }
}