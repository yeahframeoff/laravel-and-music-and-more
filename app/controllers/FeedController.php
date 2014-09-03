<?php

namespace Karma\Controllers;

use \Karma\Auth;
use \Karma\API;
use Karma\Entities\Post;
use \View;


class FeedController extends BaseController
{
    public function index()
    {
        $posts = Post::with('tracks', 'playlists', 'author')
            ->orderBy('created_at', 'desc')->get();
        return View::make('feed')->with('posts', $posts);
    }

    public function create()
    {
        $friends = \KAuth::user()->friends();
        $tracks  = \KAuth::user()->tracks->map(function($t) {return $t->track;});
        $lists   = \KAuth::user()->playlists;
        return View::make('post_form')
            ->with([
                'friends'   => $friends,
                'tracks'    => $tracks ,
                'playlists' => $lists  ,
            ]);
    }

    public function edit($id)
    {

    }

    public function store()
    {
        $input = \Input::all();
        $post = new Post;
        $post->text = $input['text'];
        $post->author()->associate(\KAuth::user());
        $post->save();
        $post->tracks()->sync(explode(' ', $input['tracks']));
        $post->playlists()->sync(explode(' ', $input['playlists']));
        $post->save();
        return \Redirect::route('library.index');
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
            ->with('playlists', OAuth::getUser()->playlists()->get())
            ->with('playlist', $playlist);
    }

    public function delete($id)
    {
        Playlist::find($id)->delete();
    }
}