<?php

namespace Karma\Controllers;

use Input;
use \Karma\Auth;
use \Karma\API;
use Karma\Entities\Post;
use Karma\Entities\NotifType;
use \KAuth;
use \Redirect;
use \Request;
use \Response;
use \View;


class FeedController extends BaseController
{
    public function index()
    {
        $posts = Post::common()->with('tracks', 'playlists', 'author')
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
        if (!empty($input['receiver']))
            $post->receiver_id = $input['receiver'];
        $post->save();
        if (isset($input['tracks']))
            $post->tracks()->sync($input['tracks']);
        if (isset($input['playlists']))
            $post->playlists()->sync($input['playlists']);
        $post->save();
        if ($post->receiver_id !== null)
            $post->notify($post->receiver_id, NotifType::FEED_POST);
        return Redirect::route('feed.index');
    }

    public function update($id)
    {
        $input = Input::all();
        $post = Post::find($id);
        $post->text = $input['text'];
        $post->save();
        if (isset($input['tracks']))
            $post->tracks()->sync($input['tracks']);
        if (isset($input['playlists']))
            $post->playlists()->sync($input['playlists']);
        $post->push();
        return Redirect::route('feed.index');
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post->author_id == KAuth::getUserId())
        {
            $post->unnotify($post->receiver_id, NotifType::FEED_POST);
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