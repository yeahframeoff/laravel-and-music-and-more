<?php

namespace Karma\DataAccess;

class EloquentTracksRepository implements TracksRepository
{
    public function find($id)
    {
        return Track::find($id);
    }
    
    public function all()
    {
        return Track::all();
    }
    
    public function create()
    {
        return new Track;
    }
    
    public function searchByTitle($title)
    {
        return Track::where('title', 'LIKE', '%' . $title . '%');
    }
    
    public function searchByGenre($genre_id)
    {
        return Track::where('genre_id', '=', $genre_id);
    }
}