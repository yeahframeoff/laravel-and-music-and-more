<?php

namespace Karma\Controllers;

use \View;
use \Session;
use \Input;
use \Redirect;
use \Karma\Entities\User;
use \Karma\Entities\Group;
use \Karma\Auth\Oauth;
use \Karma\Entities\GroupTrack;
use \Karma\Entities\Genre;

class GroupController extends BaseController
{

    public function index()
    {
        return View::make('group.index')
            ->with('groups', Group::all());
    }

    public function create()
    {
        return View::make('group.group_form')
            ->with('tracks', OAuth::getUser()->tracks);
    }

    public function edit($id)
    {
        return View::make('group.group_form')
            ->with('tracks', OAuth::getUser()->tracks)
            ->with('group', Group::find($id));
    }

    public function store()
    {
        $input = Input::all();
        array_shift($input);

        $genre = Genre::firstOrCreate(array('name' => $input['genre']));

        $group = new Group();
        $group->name = $input['name'];
        $group->description = $input['desc'];
        $group->founder_id = OAuth::getUser()->id;
        $group->genre_id = $genre->id;
        $group->avatar = $input['avatar'];
        $group->save();

        array_splice($input, 0, 4);
        foreach ($input as $trackId){
            $params = array(
                'group_id' => $group->id,
                'imported_track_id' => $trackId
            );
            $groupTrack = new GroupTrack($params);
            $groupTrack->save();
        }

        return Redirect::route('groups.index');
    }

    public function update($id)
    {
        $input = Input::all();
        array_shift($input);
        array_shift($input);

        $group = Group::find($id);
        $group->name = $input['name'];
        $group->description = $input['desc'];
        $group->avatar = $input['avatar'];
        $group->save();

        return Redirect::route('groups.index');
    }

    public function show($groupId)
    {
        $group = Group::find($groupId);
        return View::make('group.show')
            ->with('group', $group);
    }

    public function destroy($id)
    {
        Group::find($id)->delete();
    }

    public function selectedGenre($genreId)
    {
        return View::make('group.index')
            ->with('groups', Group::where('genre_id', $genreId)->get());
    }
}