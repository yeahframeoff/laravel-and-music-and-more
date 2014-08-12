<?php

namespace Karma\Entities;

use \DB;

class User extends \Eloquent
{
    protected $fillable = array('id', 'first_name', 'second_name', 'photo');

    public function credentials()
    {
        return $this->hasMany('Karma\Entities\Credential');
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

    public function socials()
    {
        return Social::whereIn('name', $this->credentials()->lists('social_id'));
    }

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
    
    public function sendRequest($id)
    {
        DB::table('friends')->insert(array('user_id' => $this->id,
                                           'friend_id' => $id,
                                           'confirmed' => false));
    }
    public function removeRequest($id)
    {
        DB::table('friends')->where('user_id', $this->id)
            ->where('friend_id', $id)
            ->where('confirmed', false)
            ->delete();
    }

    public function isFriend($id)
    {
        return DB::table('friends')->where('user_id', $this->id)
            ->where('friend_id', $id)
            ->where('confirmed', true)
            ->exists();
    }
    public function deleteFriend($id)
    {
        DB::table('friends')->where('confirmed', true)
            ->where(function($query) use($id) {
                $query->where('user_id', $this->id)
                    ->where('friend_id', $id)
                    ->orWhere('user_id', $id)
                    ->where('friend_id', $this->id);
            })
            ->delete();
    }
    
    public function confirmFriend($id)
    {
        DB::table('friends')->where('user_id', $id)
            ->where('friend_id', $this->id)
            ->update(array('confirmed' => true));
        DB::table('friends')->insert(array('user_id' => $this->id,
                                           'friend_id' => $id,
                                           'confirmed' => true));
    }
    
    public function forceFriendshipTo($id)
    {
        DB::table('friends')->insert(array('user_id' => $this->id,
                                           'friend_id' => $id,
                                           'confirmed' => true));
        
        DB::table('friends')->insert(array('user_id' => $id,
                                           'friend_id' => $this->id,
                                           'confirmed' => true));
    }
}