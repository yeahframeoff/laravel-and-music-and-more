<?php

namespace Karma\Entities;

class PlaylistsTrack extends Eloquent
{
    protected $table = 'playlist_tracks';
    protected $fillable = array('id', 'playlist_id', 'imported_track_id', 'track_number');
    protected $timestamps = false;
}