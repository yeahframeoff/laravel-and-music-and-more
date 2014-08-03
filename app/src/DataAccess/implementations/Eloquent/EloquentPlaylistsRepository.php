<?php

namespace Karma\DataAccess;

class EloquentPlaylistsRepository implements PlaylistsRepository
{
    public function find($id)
    {
        return Playlist::find($id);
    }
    
    public function all()
    {
        return Playlist::all();
    }
    
    public function create()
    {
        return new Playlist;
    }
}