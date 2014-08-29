<?php

namespace Karma\Controllers;

use \Karma\Entities\Playlist;
use \Karma\Entities\PlaylistsTrack;
use \Karma\Entities\User;
use \Karma\Auth\Oauth;
use \View;
use \Input;
use \Redirect;

class LibraryController extends BaseController
{
    public function index()
    {
        return View::make('library.library')
            ->with('tracks', OAuth::getUser()->tracks)
            ->with('playlists',OAuth::getUser()->playlists()->get());
    }

    public function userAudio($user)
    {
        return View::make('library.library')
            ->with('tracks', $user->tracks)
            ->with('playlists', $user->playlists);
    }

    public function create()
    {
        return View::make('library.playlist_form')
            ->with('tracks', OAuth::getUser()->tracks);
    }

    public function edit($id)
    {
        return View::make('library.playlist_form')
            ->with('tracks', OAuth::getUser()->tracks)
            ->with('playlist', Playlist::find($id));
    }

    public function store()
    {
        $input = Input::all();
        array_shift($input);

        $playlist = new Playlist;
        $playlist->name = $input['name'];
        $playlist->user_id = OAuth::getUser()->id;
        $playlist->save();

        array_shift($input);
        $trackNumber = 1;
        foreach ($input as $trackId){
            $params = array(
                'playlist_id' => $playlist->id,
                'imported_track_id' => $trackId,
                'track_number' => $trackNumber
            );
            $playlistTrack = new PlaylistsTrack($params);
            $playlistTrack->save();
            $trackNumber++;
        }

        return Redirect::route('library.index');
    }

    public function update($id)
    {
        $input = Input::all();
        array_shift($input);
        array_shift($input);

        $playlist = Playlist::find($id);
        $playlist->name = $input['name'];
        $playlist->save();

        /*
         * TODO optimization to 1 query
         */
        foreach ($playlist->playlistTracks as $playlistTrack){
            $playlistTrack->delete();
        }

        array_shift($input);
        $trackNumber = 1;
        foreach ($input as $trackId){
            $params = array(
                'playlist_id' => $playlist->id,
                'imported_track_id' => $trackId,
                'track_number' => $trackNumber
            );
            $playlistTrack = new PlaylistsTrack($params);
            $playlistTrack->save();
            $trackNumber++;
        }

        return Redirect::route('library.index');
    }

    public function show($playlistId)
    {
        $playlist = Playlist::find($playlistId);
        return View::make('library.library')
            ->with('tracks', $playlist->tracks)
            ->with('playlists',OAuth::getUser()->playlists()->get());
    }

    public function delete($id)
    {
        Playlist::find($id)->delete();
    }
}