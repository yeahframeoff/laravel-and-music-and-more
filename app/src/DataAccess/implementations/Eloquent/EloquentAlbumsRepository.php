<?php

namespace Karma\DataAccess;

class EloquentAlbumsRepository implements AlbumsRepository
{
    public function find($id)
    {
        return Album::find($id);
    }
    
    public function all()
    {
        return Album::all();
    }
    
    public function create()
    {
        return new Album;
    }
}