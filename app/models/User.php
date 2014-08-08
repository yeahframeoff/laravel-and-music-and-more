<?php

namespace Karma\Entities;

class User extends Eloquent implements UserInterface {

    use UserTrait;

    protected $fillable = array('id', 'first_name', 'second_name', 'photo');

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
    
    public function socials()
    {
        return $this->credentials()->lists('external_id', 'social_id');
    }
}
