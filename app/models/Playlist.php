<?php

namespace Karma\Entities;

class Playlist extends \Eloquent
{
	protected $fillable = array('id', 'user_id', 'name');
    
    public function tracks()
    {
        return $this->belongsToMany('ImportedTrack', 'playlist_track');
    }
    
    public function user()
    {
        return $this->hasOne('User');
    }
}