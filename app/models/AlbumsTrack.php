<?php

namespace Karma\Entities;

class AlbumsTrack extends Eloquent
{
    protected $table = 'albums_to_tracks';
    protected $fillable = array('id', 'album_id', 'track_id');
    protected $timestamps = false;
}