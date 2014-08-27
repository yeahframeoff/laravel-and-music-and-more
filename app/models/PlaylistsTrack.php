<?php

namespace Karma\Entities;

class PlaylistsTrack extends \Eloquent
{
    protected $table = 'playlist_track';
    protected $fillable = array('id', 'playlist_id', 'imported_track_id', 'track_number');
    public $timestamps = false;

    public function playlist()
    {
        return $this->belongsTo('Karma\Entities\Playlist', 'playlist_id');
    }
}