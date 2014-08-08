<?php

namespace Karma\Entities;

class User extends \Eloquent implements UserInterface {

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
        return $this->belongsToMany('ImportedTrack', 'imported_track_user');
    }
    
    public function settings()
    {
        return $this->hasMany('Setting');
    }
	
    public function chats()
    {
        return $this->belongsToMany('Chat');
    }
    
    public function friends()
    {
        return self::whereIn('id', DB::table('friends')->where('user_id', $this->id)->lists('friend_id'));
    }
    
    public function socials()
    {
        return $this->credentials()->lists('external_id', 'social_id');
    }
    
    public function addFriend($id)
    {
        DB::table('friends')->insert(array('user_id' => $this->id, 'friend_id' => $id));
    }
}
