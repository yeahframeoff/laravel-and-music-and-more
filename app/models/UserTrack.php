<?php

namespace Karma\Entities;

class UserTrack extends \Eloquent
{
    protected $table = 'user_tracks';
    protected $fillable = array('id', 'user_id', 'imported_track_id');
    public $timestamps = false;
}