<?php

namespace Karma\Entities;

use \Karma\Entities\User;

trait NotifyingTrait
{
    public function notifications()
    {
        return $this->morphMany('Karma\Entities\Notification', 'object');
    }

    public function notify($user, $type)
    {
        \Log::info ('NOTIFYING TRAIT used: NOTIFY');
        if (!($user instanceof User))
            $user = User::find($user);
        $notification = new Notification();
        $notification->type = $type;
        $notification->refferedUser()->associate($user);
        $notification->object()->associate($this);
        $notification->save();
        return $this->notifications()->save($notification);
    }

}



class Notification extends \Eloquent
{
    use \SoftDeletingTrait;

    protected $table = 'notifications';
    protected $fillable = ['type'];
    //protected $dates = ['deleted_at'];

    const FRIENDS_REQUEST_NEW       = 'friends-request-new';
    const FRIENDS_REQUEST_CONFIFMED = 'friends-request-confirmed';
    const FRIENDS_REQUEST_DENIED    = 'friends-request-denied';
    const FRIENDS_DELETED           = 'friends-request-deleted';

    public function scopeChecked($query)
    {
        return $query->where('checked', '=', 1);
    }

    public function scopeUnchecked($query)
    {
        return $query->where('checked', '=', 0);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', '=', $type)->orWhere('type', 'LIKE', '%' . $type . '%');
    }

    public function refferedUser()
    {
        return $this->belongsTo('Karma\Entities\User', 'reffered_user_id');
    }

    public function object()
    {
        return $this->morphTo('object');
    }
} 