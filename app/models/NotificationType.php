<?php

namespace Karma\Entities;

class NotificationType extends \Eloquent
{
    protected $fillable = ['title', 'entity_name'];
    protected $table = 'notification_types';
    public $timestamps = false;

    public function notifications()
    {
        return $this->hasMany('\Karma\Entity\Notification', 'notification_type_id');
    }

    const TITLE_FRIEND_NEW_REQUEST = 'friend-new-request';

    public function scopeNewFriendRequest($query)
    {
        return $query->where('title', 'like', self::TITLE_FRIEND_NEW_REQUEST);
    }
} 