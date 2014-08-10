<?php

namespace Karma\Entities;

class ImportedTrack extends \Eloquent
{
    protected $table = 'imported_tracks';
    protected $fillable = array('id', 'social_id', 'track_id', 'track_url');
    public $timestamps = false;
    
    public function track()
    {
        return $this->hasOne('Track');
    }
}