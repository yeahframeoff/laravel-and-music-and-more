<?php

namespace Karma\Entities;

class PlaylistTrack extends \Eloquent
{
    protected $table = 'playlist_track';
    protected $fillable = array('id', 'playlist_id', 'imported_track_id', 'track_number');
    public $timestamps = false;
    
    public static function getTrackNumber($playlist_id, $imported_track_id)
    {
        $track = self::where('playlist_id', $playlist_id)
                     ->where('imported_track_id', $imported_track_id)
                     ->first();
        
        if($track->exists())
        {
            return $track->track_number;
        }
        else
        {
            return false;
        }
    }
}