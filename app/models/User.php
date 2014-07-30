<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

namespace Karma\Entities;

class User extends Entity implements UserInterface {

	use UserTrait;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
    
    protected $fillable = array('id', 'login', 'password');
    
    protected $rules = array('login'    => 'required|min:3|max:20|alphanum',
                             'password' => 'required|min:6|max:30');
    
    public function credentials()
    {
        return $this->hasMany('Credential');
    }    
	
}
