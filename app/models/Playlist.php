<?php

namespace Karma\Entities;

class Playlist extends \Eloquent
{
	protected $fillable = array('id', 'user_id', 'name');
    
    public function tracks()
    {
        return $this->belongsToMany('Karma\Entities\ImportedTrack', 'playlist_track');
    }
    
    public function user()
    {
        return $this->hasOne('Karma\Entities\User');
    }

    public function playlistTracks()
    {
        return $this->hasMany('Karma\Entities\PlaylistsTrack', 'playlist_id');
    }
}