<?php

namespace Karma\Entities;

use \DB;
use \Session;
use \Karma\Entities\ImportedTrack;

class User extends \Eloquent
{
    use NotifyingTrait;

    protected $fillable = array('id', 'first_name', 'last_name', 'photo');

    protected $appends = array('profileUrl');

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
        return $this->belongsToMany('Karma\Entities\Social', 'credentials');
    }

    public function groups()
    {
        return $this->belongsToMany('Karma\Entities\Group');
    }

    public function receivedPosts()
    {
        return $this->hasMany('Karma\Entities\Post', 'receiver_id');
    }

    public function friendships()
    {
        return $this->hasMany('Karma\Entities\Friend', 'user_id');
    }

    public function friendshipz()
    {
        return $this->hasMany('Karma\Entities\Friend', 'friend_id');
    }

    public function friends()
    {
        return $this->theFriends()->get()->merge($this->theFriendz()->get());
    }

    public function theFriends()
    {
        return $this->belongsToMany('Karma\Entities\User', 'friends', 'user_id', 'friend_id')
            ->withPivot('confirmed')->where('confirmed', '=', true);
    }

    public function theFriendz()
    {
        return $this->belongsToMany('Karma\Entities\User', 'friends', 'friend_id', 'user_id')
            ->withPivot('confirmed')->where('confirmed', '=', true);
    }

    public function posts()
    {
        return $this->hasMany('Karma\Entities\Post', 'author_id');
    }

    public function getProfileUrlAttribute()
    {
        return \URL::to("/profile/{$this->id}");
    }

    public function sendRequest($user, $notify = true)
    {
        $id = $user instanceof User ?  $user->id : $user;
        $this->theFriends()->attach($id);
        if ($notify == true)
            $this->notify($user, NotifType::FRIENDS_REQUEST_NEW);
    }

    public function removeRequest($id, $notify = true)
    {
        $this->friendships()->requests()->where('friend_id', '=', $id)->delete();
        \Log::info('REMOVE REQUEST OK');
        $this->unnotify($id, NotifType::FRIENDS_REQUEST_NEW);
        if ($notify == true)
            $this->notify($id, NotifType::FRIENDS_REQUEST_REMOVED);
    }

    public function isFriend($id)
    {
        return $this->friendships()->where('friend_id', '=', $id)->where('confirmed', '=', true)->exists() ||
               $this->friendshipz()->where('user_id', '=', $id)->where('confirmed', '=', true)->exists();
               //$this->theFriendz()->where('id', '=', $id)->exists();
    }

    public function deleteFriend($id, $notify = true)
    {
        $this->theFriends()->detach($id);
        $this->theFriendz()->detach($id);
        if ($notify)
            $this->notify($id, NotifType::FRIENDS_DELETED);
    }

    public function confirmFriend($user, $notify = true)
    {
        if ($user instanceof User)
            $user = $user->id;
        $this->friendshipz()->requests()->where('user_id', '=', $user)
            ->update(['confirmed' => true]);

        if ($notify == true)
            $this->notify($user, NotifType::FRIENDS_REQUEST_CONFIFMED);
    }

    public function forceFriendshipTo($id, $unnotify = true)
    {
        //$this->sendRequest($id, false);
        //User::find($id)->confirmFriend($this, false);
        $this->theFriends()->attach($id, ['confirmed' => true]);
        if ($unnotify)
            $this->unnotify($id, NotifType::FRIENDS_DELETED);
    }

    public function notifications()
    {
        return $this->hasMany('\Karma\Entities\Notification', 'reffered_user_id');
    }

    public function __toString()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getMessageParams($type)
    {
        switch ($type)
        {
            case NotifType::FRIENDS_REQUEST_NEW:
            case NotifType::FRIENDS_REQUEST_REMOVED:
            case NotifType::FRIENDS_REQUEST_CONFIFMED:
            case NotifType::FRIENDS_REQUEST_DENIED:
            case NotifType::FRIENDS_DELETED:
                return ['user' => strval($this)];
            default:
                return [];
        }

    }

    public function getUrlParams($type)
    {
        switch ($type)
        {
            case NotifType::FRIENDS_REQUEST_NEW:
            case NotifType::FRIENDS_REQUEST_REMOVED:
            case NotifType::FRIENDS_REQUEST_CONFIFMED:
            case NotifType::FRIENDS_REQUEST_DENIED:
            case NotifType::FRIENDS_DELETED:
                return ['user' => $this->id];
            default:
                return [];
        }

    }
}
