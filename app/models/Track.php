<?php

namespace Karma\Entities;

class Track extends \Eloquent
{
    protected $fillable = array('id', 'artist_id', 'genre_id', 'title', 'lyrics');
    public $timestamps = false;
        
    public function artist()
    {
        return $this->belongsTo('Karma\Entities\Artist');
    }
    
    public function albums()
    {
        return $this->belongsToMany('Karma\Entities\Album');
    }
    
    public function genre()
    {
        return $this->belongsTo('Karma\Entities\Genre');
    }

    public function rates()
    {
        return $this->morhpMany('Karma\Entities\Rate', 'rated_object');
    }

    public function posts()
    {
        return $this->morphToMany('Karma\Entities\Post', 'post_item', 'posts_postitems');
    }
}