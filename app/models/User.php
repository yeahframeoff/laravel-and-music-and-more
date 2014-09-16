<?php

namespace Karma\Entities;

use \DB;
use \Session;
use \Karma\Entities\ImportedTrack;

class User extends \Eloquent
{
    use \Karma\Util\WhatUserCanDoTrait;

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

    public function myGroups()
    {
        return $this->hasMany('Karma\Entities\Group', 'founder_id');
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

    public function notifications()
    {
        return $this->hasMany('\Karma\Entities\Notification', 'reffered_user_id');
    }

    public function __toString()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

}
