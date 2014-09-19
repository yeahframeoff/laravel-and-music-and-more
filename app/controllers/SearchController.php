<?php

namespace Karma\Controllers;

use \Input;
use Karma\Util\Search;
use Karma\Wrappers\TrackTileWrapper;
use Karma\Wrappers\UserTileWrapper;
use \View;

class SearchController extends BaseController
{
    public function index()
    {
        return View::make('search');
    }
    
    public function searchForPeople()
    {
        $whom = Input::get('q', '');
        $people = Search::search($whom, '\Karma\Entities\User', ['first_name', 'last_name'], array(), ['count' => 12]);
        return \Response::json([
            'page' => 'people',
            'result' => UserTileWrapper::wrapMany($people),
        ]);
    }
    
    public function searchForMusic()
    {
        $what = Input::get('q', '');
        $tracks = Search::search(
            $what, '\Karma\Entities\Track', ['title', 'lyrics'],
            [
                'artist' => ['name', 'bio'],
                'albums' => 'name',
                'genre'  => 'name'
            ],
            ['count' => 20]
        );
        return \Response::json([
            'page' => 'music',
            'result' => TrackTileWrapper::wrapMany($tracks),
        ]);
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
                ->with('resultArray', $resultArray)
                ->with('q', $what);
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