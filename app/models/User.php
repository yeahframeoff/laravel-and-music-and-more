<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

namespace Karma\Entities;

class User extends Entity implements UserInterface {

	use UserTrait;

    protected $fillable = array('id');
    
    public function credentials()
    {
        return $this->hasMany('Credential');
    }    
	
}
