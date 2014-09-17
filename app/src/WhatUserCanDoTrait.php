<?php

namespace Karma\Util;

trait WhatUserCanDoTrait
{
    use \Karma\Entities\NotifyingTrait;

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

    public function getMessageParams($type)
    {
        switch ($type)
        {
            case NotifType::FRIENDS_REQUEST_NEW:
            case NotifType::FRIENDS_REQUEST_REMOVED:
            case NotifType::FRIENDS_REQUEST_CONFIFMED:
            case NotifType::FRIENDS_REQUEST_DENIED:
            case NotifType::FRIENDS_DELETED:
            case NotifType::MESSAGES_NEW:
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
            case NotifType::MESSAGES_NEW:
                return ['user' => $this->id];
            default:
                return [];
        }

    }

    public function rate($object, $value)
    {
        if (is_array($object))
        {
            $class = 'Karma\Entities\\' . ($object['type'] == 'track' ? 'Track' : 'Playlist');
            $object = $class::with('rates')->find($object['id']);
        }
        else
            $object->load('rates');

        if ($rate = $object->rates()->where('rater_id', '=', $this->id)->first() === null)
        {
            $rate = new \Karma\Entities\Rate;
            $rate->rater()->associate($this);
        }
        $rate->value = $value;
        $object->rates()->save($rate);
    }
}
