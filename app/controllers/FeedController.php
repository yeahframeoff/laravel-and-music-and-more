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
        return 'EDIT '.$id;
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
        return 'UPDATE '.$id;
    }

    public function show($id)
    {
        return 'SHOW '.$id;
//        $playlist = Playlist::find($playlistId);
//        return View::make('library.library')
//            ->with('tracks', $playlist->tracks)
//            ->with('playlists', OAuth::getUser()->playlists()->get())
//            ->with('playlist', $playlist);
    }

    public function delete($id)
    {
        //Playlist::find($id)->delete();
        return 'DELETE '.$id;
    }
}