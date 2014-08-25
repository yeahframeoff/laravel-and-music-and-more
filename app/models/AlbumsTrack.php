<?php

namespace Karma\Entities;

class AlbumsTrack extends \Eloquent
{
    protected $table = 'album_track';
    protected $fillable = array('id', 'album_id', 'track_id');
    public $timestamps = false;
}