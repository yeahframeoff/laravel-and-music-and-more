<?php

namespace Karma\Controllers;

use \Karma\API\API;
use \Karma\Util\MusicInfo;
use \Karma\Entities\User;
use \Karma\Entities\Social;
use \Karma\Entities\ImportedTrack;
use \Session;
use \View;
use \Redirect;
use \Input;

class ImportController extends BaseController
{
    public function index()
    {
        $id = Session::get('user_id');
        return View::make('import')->with('socials', \Karma\Entities\User::find($id)->socials());
    }
    
    public function import($provider)
    {
        $API = API::getAPI($provider);
        
        $tracks = $API->getUserAudio();
        return View::make('importSelect')
            ->with('tracks', $tracks)
            ->with('provider', $provider);
    }

    public function importSelect($provider)
    {
        $input = Input::all();
        array_shift($input);
        $tracks = array();
        foreach ($input as $track => $artist){
            if($artist == "on")
                continue;
            $tmpArray = explode('|', $artist);
            $_track = array('title' => $track, 'artist' => $tmpArray[0], 'url'=>$tmpArray[1]);
            $tracks[] =  $_track;
        }

        foreach ($tracks as $track){

            //TODO try to musicInfo???
            try {
                $_track = MusicInfo::getTrackByArtistAndTitle($track['artist'], $track['title']);
            } catch (\Exception $e) {
                continue;
            }
            $params = array(
                'social_id' => Social::byName($provider)->id,
                'track_id' => $_track->id,
                'track_url' => $track['url']
            );
            $importedTrack = ImportedTrack::firstOrNew($params);
            if($importedTrack->exists == false){
                $importedTrack->save();
                $importedTrack->connectWithUser(Session::get('user_id'));
            }
        }
        return Redirect::action('profileIndex');
    }
}