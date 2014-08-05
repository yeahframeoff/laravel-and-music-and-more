<?php

namespace Karma\Entities;

class AlbumsGenre extends Eloquent
{
    protected $table = 'album_genres';
    protected $fillable = array('id', 'album_id', 'genre_id');
    protected $timestamps = false;
}