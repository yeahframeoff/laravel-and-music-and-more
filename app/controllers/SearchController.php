<?php

namespace Karma\Controllers;

class SearchController extends BaseController
{
    public function search($for, $what)
    {
        $method = 'searchFor'.ucfirst($for);
        
        if(!method_exists($this, $method))
            return App::abort(404);
        else
            return $this->$method(urldecode($what));
    }
    
    protected function searchForPeople()
    {
        $whom = \Input::has('q') ? \Input::get('q') : '';
        $people = \Karma\Util\Search::search(
            $whom, '\Karma\Entities\User', ['first_name', 'last_name']
        );
        return \View::make('search', ['page' => 'people', 'result' => $people]);
    }
    
    protected function searchForMusic()
    {
        $what = \Input::has('q') ? \Input::get('q') : '';
        $tracks = \Karma\Util\Search::search(
            $what, '\Karma\Entities\Track', ['title', 'lyrics'],
            [
                'artist' => ['name', 'bio'],
                'albums' => 'name',
                'genre'  => 'name'
            ]
        );
        return \View::make('search', ['page' => 'music', 'result' => $tracks]);
    }
    
    protected function searchForGroups($what)
    {
        
    }
}