<?php

namespace Karma\Controllers;

use \Input;
use Karma\Util\Search;
use \View;

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
        $whom = Input::get('q', '');
        $people = Search::search(
            $whom, '\Karma\Entities\User', ['first_name', 'last_name']
        );
        return View::make('search', ['page' => 'people', 'result' => $people]);
    }
    
    protected function searchForMusic()
    {
        $what = Input::get('q', '');
        $tracks = Search::search(
            $what, '\Karma\Entities\Track', ['title', 'lyrics'],
            [
                'artist' => ['name', 'bio'],
                'albums' => 'name',
                'genre'  => 'name'
            ]
        );
        return View::make('search', ['page' => 'music', 'result' => $tracks]);
    }
    
    protected function searchForGroups($what)
    {
        
    }

    protected function searchDeezer()
    {
        $what = Input::get('q', '');
        if(Input::has('q')){
            $results = Search::searchDeezer($what);
            $resultArray = array();
            foreach($results as $result){
                $resultArray[$result->type][] = $result;
            }
            return View::make('search.deezer')
                ->with('resultArray', $resultArray);
        }
        else
            return View::make('search.index');
    }

    protected function artistPage($id)
    {
        $artist = new \DeezerAPI\Models\Artist($id);
        return View::make('search.artist')
            ->with('artist', $artist);
    }
}