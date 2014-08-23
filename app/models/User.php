<?php

namespace Karma\Entities;

use \DB;
use \Session;
use \Karma\Entities\ImportedTrack;

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

    public function friendships()
    {
        return $this->hasMany('Karma\Entities\Friend', 'user_id');
    }

    public function socials()
    {
        $credentials = $this->credentials();
        $socials = Social::whereIn('id', $credentials->lists('social_id'))->lists('id', 'name');
        
        foreach($socials as $social => $id)
        {
            $socials[$social] = $credentials->where('social_id', $id)->first();
        }
        
        return $socials;
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

//        return self::with(['friendships' => function($query) use ($this){
//                $query->where('user_id', '=', $this->id)->where('confirmed', '=', true);
//            }]);
    }

    public function profileUrl()
    {
        return \URL::to("/profile/{$this->id}");
    }

    public function friendshipRequests($onlyCount = false)
    {
        $list = DB::table('friends')->where('friend_id', $this->id)
            ->where('confirmed', false)
            ->lists('user_id');

        if(count($list) != 0)
            return $onlyCount ? count($list) : self::whereIn('id', $list)->get();

        else
            return $onlyCount ? 0 : array();

//        return self::friendships()->where('friend_id', '=', $this->id)
//            ->where('confirmed', '=', false)->friend();
    }

    public function friendshipRequestsCount()
    {
        return $this->friendshipRequests(true);
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

    public function sentFriendshipRequestTo($id)
    {
        $sent = DB::table('friends')
            ->where('user_id', $this->id)
            ->where('friend_id', $id)
            ->where('confirmed', false)->first();
        return $sent !== null;
    }

    public function gotFriendshipRequestFrom($id)
    {
        $received = DB::table('friends')
            ->where('user_id', $id)
            ->where('friend_id', $this->id)
            ->where('confirmed', false)->first();

        \Log::info('Received !== null: '.($received !== null));
        \Log::info('Received === null: '.($received === null));
        return $received !== null;
    }

    public function sendRequest($id)
    {
//        DB::table('friends')->insert(array('user_id' => $this->id,
//                                           'friend_id' => $id,
//                                           'confirmed' => false));
        $friend = Friend::create(['user_id' => $this->id,
                        'friend_id' => $id]);
        $friend->notify($id, Notification::FRIENDS_REQUEST_NEW);
    }

    public function removeRequest($id)
    {
//        DB::table('friends')->where('user_id', $this->id)
//            ->where('friend_id', $id)
//            ->where('confirmed', false)
//            ->delete();

        $friend = Friend::where('user_id', '=', $this->id)
            ->where('friend_id', '=', $id)
            ->where('confirmed', '=', false)->first();

        if ($friend === null)
            return;

        $friend->notifications()->where('type', '=', Notification::FRIENDS_REQUEST_NEW)->delete();
        $friend->delete();
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
        $friend = Friend::where('user_id', '=', $id)
            ->where('friend_id', '=', $this->id)->first();
        $friend->update(['confirmed' => true]);
        $friend->notify($id, Notification::FRIENDS_REQUEST_CONFIFMED);

        Friend::create(['user_id' => $this->id,
                        'friend_id' => $id,
                        'confirmed' => true]);
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

    public function notifications()
    {
        return $this->hasMany('\Karma\Entities\Notification', 'reffered_user_id');
    }
}
