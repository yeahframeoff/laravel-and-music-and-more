<?php

namespace Karma\Controllers;

use \Karma\Entities\Playlist;

class LibraryController extends BaseController
{
    public function index()
    {
        return \View::make('library')
            ->with('tracks', \Karma\Entities\Track::all())
            ->with('playlists', \Karma\Auth\OAuth::getUser()->playlists()->get());
    }
    
    public function createPlaylist($name)
    {
        $playlist = new Playlist;
        
        $playlist->name = $name;
        $playlist->user()->save(\Karma\Auth\Oauth::getUser());
        $playlist->push();
        
        return \Redirect::route('library');
    }
    
    public function deletePlaylist($id)
    {
        Playlist::find($id)->delete();
    }
}