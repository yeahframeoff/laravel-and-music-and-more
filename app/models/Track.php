<?php

namespace Karma\Entities;

class Track extends \Eloquent
{
    protected $fillable = array('id', 'artist_id', 'genre_id', 'title', 'lyrics');
    public $timestamps = false;
        
    public function artist()
    {
        return $this->hasOne('Karma\Entities\Artist');
    }
    
    public function albums()
    {
        return $this->belongsToMany('Karma\Entities\Album');
    }
    
    public function genre()
    {
        return $this->hasOne('Karma\Entities\Genre');
    }
}