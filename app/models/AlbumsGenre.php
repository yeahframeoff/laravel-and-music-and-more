<?php

namespace Karma\Entities;

class AlbumsGenre extends Eloquent
{
    protected $table = 'albums_to_genres';
    protected $fillable = array('id', 'album_id', 'genre_id');
    protected $timestamps = false;
}