<?php

namespace Karma\Entities;

class Track extends Eloquent
{
    protected $fillable = array('id', 'artist_id', 'genre_id', 'title', 'lyrics');
    protected $timestamps = false;
        
    public function artist()
    {
        return $this->hasOne('Artist');
    }
    
    public function albums()
    {
        return $this->hasManyThrough('AlbumsTrack', 'Album');
    }
    
    public function genre()
    {
        return $this->hasOne('Genre');
    }
}