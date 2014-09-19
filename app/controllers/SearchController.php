<?php

namespace Karma\Controllers;

use \Input;
use Karma\Util\Search;
use Karma\Wrappers\UserTileWrapper;
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
    
    public function searchForPeople()
    {
        $whom = Input::get('q', '');
        $people = Search::search($whom, '\Karma\Entities\User', ['first_name', 'last_name'], array(), ['count' => 12]);
        return $this->resolveResponse('search', [
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
            ]
        );
        return $this->resolveResponse('search', [
            'page' => 'music',
            'result' => $tracks
        ]);
    }

    protected function resolveResponse($view, array $responseData)
    {
        if (\Request::ajax())
            return \Response::json($responseData);
        else
            return View::make($view, $responseData);
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