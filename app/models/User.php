<?php

namespace Karma\Entities;

use \DB;

class User extends \Eloquent{

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

    /*
    public function friends()
    {
        return $this->belongsToMany('Karma\Entities\User', 'friends', 'user_id', 'friend_id');
    }
    */

    public function friends()
    {
        $list = DB::table('friends')->where('user_id', $this->id)
            ->where('confirmed', true)
            ->lists('friend_id');
        if(count($list) != 0)
            return self::whereIn('id', $list)->get();
        else
            return array();

    }

    public function friendshipRequests()
    {
        $list = DB::table('friends')->where('friend_id', $this->id)
            ->where('confirmed', false)
            ->lists('user_id');
        if(count($list) != 0)
            return self::whereIn('id', $list)->get();
        else
            return array();
    }

    public function sentFriendshipRequests()
    {
        $list = DB::table('friends')->where('user_id', $this->id)
            ->where('confirmed', false)
            ->lists('friend_id');
        if(count($list) != 0)
            return self::whereIn('id', $list)->get();
        else
            return array();
    }

    public function socials()
    {
        return $this->credentials()->lists('external_id', 'social_id');
    }

}
