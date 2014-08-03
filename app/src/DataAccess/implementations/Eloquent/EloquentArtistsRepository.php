<?php

namespace Karma\DataAccess;

class EloquentArtistsRepository implements ArtistsRepository
{
    public function find($id)
    {
        return Artist::find($id);
    }
    
    public function all()
    {
        return Artist::all();
    }
    
    public function create()
    {
        return new Artist;
    }
}