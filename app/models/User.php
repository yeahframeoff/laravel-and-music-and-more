<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

<<<<<<< HEAD
namespace Karma\Entities;

class User extends Entity implements UserInterface {

	use UserTrait;

    protected $fillable = array('id');
    
    public function credentials()
    {
        return $this->hasMany('Credential');
    }    
	
=======
class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

>>>>>>> a19cfd3e6badb349112e0ebb9913bb04421d60fc
}
