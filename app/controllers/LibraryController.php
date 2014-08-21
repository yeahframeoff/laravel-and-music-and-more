<?php

namespace Karma\Controllers;

class LibraryController extends BaseController
{
    public function index()
    {
        return View::make('library');
    }
    
    public function createPlaylist($name)
    {
        $playlist = new Playlist;
        
        $playlist->name = $name;
        $playlist->user_id = Session::get('user_id');
        $playlist->save();
        
        return Redirect::route('library');
    }
    
    public function deletePlaylist($id)
    {
        Playlist::find($id)->delete();
    }
}