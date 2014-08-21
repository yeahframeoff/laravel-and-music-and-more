<?php

namespace Karma\Entities;

use \Karma\Entities\User;

trait NotifyingTrait
{
    public function notifications()
    {
        return $this->morphMany('Karma\Entities\Notification', 'notificationObject');
    }

    public function notify($user)
    {
        if (!($user instanceof User))
            $user = User::find($user);
        $notification = new Notification();
        $notification->type()->associate(self::getNotificationType());
        $notification->refferedUser()->associate($user);
        $notification->object()->associate($this);
        $notification->save();
        return $this->notifications()->save($notification);
    }

    abstract static function getNotificationType();

}

class Notification extends \Eloquent
{
    use \SoftDeletingTrait;

    protected $table = 'notifications';
    //protected $fillable = [];
    //protected $dates = ['deleted_at'];

    public function scopeChecked($query)
    {
        return $query->where('checked', '=', 1);
    }

    public function scopeUnchecked($query)
    {
        return $query->where('checked', '=', 0);
    }

    public function referredUser()
    {
        return $this->belongsTo('Karma\Entities\User', 'referred_user_id');
    }

    public function type()
    {
        return $this->belongsTo('Karma\Entities\NotificationType');
    }

    public function object()
    {
        return $this->morphTo('notification_object');
    }
} 