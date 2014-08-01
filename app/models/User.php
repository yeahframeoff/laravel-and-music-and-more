<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

namespace Karma\Entities;

class User extends Eloquent implements UserInterface {

    use UserTrait;

    protected $fillable = array('id');

    public function credentials()
    {
        return $this->hasMany('Credential');
    }
    
    public function playlists()
    {
        return $this->hasMany('Playlist');
    }
    
    public function tracks()
    {
        return $this->hasMany('UserTrack');
    }
    
    public function settings()
    {
        return $this->hasMany('Setting');
    }
	
    public function chats()
    {
        return $this->hasManyThrough('ChatUsers', 'Chat');
    }
    
    public function friends()
    {
        return $this->hasManyThrough('Friend', 'User');
    }
    
    public function preferredGenres()
    {
                               
    }
}
