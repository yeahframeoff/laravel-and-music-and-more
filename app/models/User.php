<?php

namespace Karma\Entities;

use \DB;

class User extends \Eloquent
{
    protected $fillable = array('id', 'first_name', 'last_name', 'photo');

    public function credentials()
    {
        return $this->hasMany('Karma\Entities\Credential');
    }    

    public function playlists()
    {
        return $this->hasMany('Karma\Entities\Playlist');
    }

    public function tracks()
    {
        return $this->belongsToMany('Karma\Entities\ImportedTrack', 'imported_track_user');
    }

    public function settings()
    {
        return $this->hasMany('Karma\Entities\Setting');
    }

    public function chats()
    {
        return $this->belongsToMany('Karma\Entities\Chat');
    }

    public function socials()
    {
        $credentials = $this->credentials();
        $socials = Social::whereIn('id', $credentials->lists('social_id'))->lists('id', 'name');
        
        foreach($socials as $social => $id)
        {
            $socials[$social] = $credentials->where('id', $id)->pluck('main');
        }
    }
    
    public function groups()
    {
        return $this->belongsToMany('Karma\Entities\Group');
    }

    public function friends()
    {
        $list = DB::table('friends')->where('user_id', $this->id)
                    ->where('confirmed', true)
                    ->lists('friend_id');
        
        if(count($list))
            return self::whereIn('id', $list)->get();
        else
            return array();

    }

    public function friendshipRequests()
    {
        $list = DB::table('friends')->where('friend_id', $this->id)
            ->where('confirmed', false)
            ->lists('user_id');
        
        if(count($list))
            return self::whereIn('id', $list)->get();
        else
            return array();
    }

    public function sentFriendshipRequests()
    {
        $list = DB::table('friends')->where('user_id', $this->id)
            ->where('confirmed', false)
            ->lists('friend_id');
        
        if(count($list))
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
    
    public function preferredArtists()
    {
        return DB::table('imported_track_user')->where('imported_track_user.user_id', $this->id)
                                               ->leftJoin('imported_tracks', 'imported_track_user.imported_track_id', '=', 'imported_tracks.id')
                                               ->leftJoin('tracks', 'imported_tracks.track_id', '=', 'tracks.id')
                                               ->lists('tracks.artist_id');
    }
}