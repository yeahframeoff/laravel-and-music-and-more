<?php

namespace Karma\Controllers;

use Input;
use \Karma\Auth;
use \Karma\API;
use Karma\Entities\Post;
use \KAuth;
use \Redirect;
use \Request;
use \Response;
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
        $post = new Post;
        $tracks = KAuth::user()->tracks->map(function($t) {return $t->track;});
        $lists  = KAuth::user()->playlists;
        return View::make('post_form')
            ->with([
                'post'      => $post,
                'tracks'    => $tracks,
                'playlists' => $lists,
            ]);
    }

    public function edit($id)
    {
        $post = Post::with('tracks', 'playlists', 'author')
            ->orderBy('created_at', 'desc')->find($id);
        $tracks = KAuth::user()->tracks
            ->map(function($t) {return $t->track;});
        $lists = KAuth::user()->playlists;
        return View::make('post_form')
            ->with([
                'post'      => $post,
                'tracks'    => $tracks,
                'playlists' => $lists,
            ]);
    }

    public function store()
    {
        $input = Input::all();
        $post = new Post;
        $post->text = $input['text'];
        $post->author()->associate(KAuth::user());
        $post->save();
        $post->tracks()->sync(explode(' ', $input['tracks']));
        $post->playlists()->sync(explode(' ', $input['playlists']));
        $post->save();
        return Redirect::route('feed.index');
    }

    public function update($id)
    {
        $input = Input::all();
        $post = Post::find($id);
        $post->text = $input['text'];
        $post->save();
        $post->tracks()->sync(explode(' ', $input['tracks']));
        $post->playlists()->sync(explode(' ', $input['playlists']));
        $post->push();
        return Redirect::route('feed.index');
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post->author_id == KAuth::getUserId())
        {
            $post->delete();
            if (Request::ajax())
                return Response::json(['url' => \URL::route('feed.index')]);
            else
                return Redirect::route('feed.index');
        }
        else
            App::abort(403, 'You cannot delete not your posts');
    }
}