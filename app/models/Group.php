<?php

namespace Karma\Entities;

class Group extends \Eloquent
{
    protected $fillable = array('id', 'founder_id', 'name', 'genre', 'description', 'avatar', 'active');
    public $timestamps = false;
    
    public function users()
    {
        return $this->belongsToMany('Karma\Entities\User');
    }
	
    public function founder()
    {
        return $this->belongsTo('Karma\Entities\User', 'founder_id');
    }

    public function genre()
    {
        return $this->belongsTo('Karma\Entities\Genre', 'genre_id');
    }

    public function tracks()
    {
        return $this->belongsToMany('Karma\Entities\ImportedTrack', 'group_track');
    }

    public function activeUsers()
    {
        return $this->belongsToMany('Karma\Entities\User', 'active_group_users');
    }

    public function isListener($user_id)
    {
        return $this->activeUsers->contains($user_id);
    }
}