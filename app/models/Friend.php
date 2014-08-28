<?php

namespace Karma\Entities;

class Friend extends \Eloquent
{
    use NotifyingTrait;

    protected $fillable = ['user_id', 'friend_id', 'confirmed'];

    public function user()
    {
        return $this->belongsTo('Karma\Entities\User', 'user_id');
    }

    public function friend()
    {
        return $this->belongsTo('Karma\Entities\User', 'friend_id');
    }

    public function scopeRequests($query)
    {
        return $query->where('confirmed', '=', false);
    }

    public function getMessageParams($type)
    {
        if ($type == NotifType::FRIENDS_REQUEST_NEW)
            return ['user' => $this->user()->first_name . ' ' . $this->user()->last_name];
    }
}