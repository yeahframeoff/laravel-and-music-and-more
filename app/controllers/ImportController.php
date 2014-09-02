<?php

namespace Karma\Controllers;

use \Karma\API\API;
use \Karma\Util\MusicInfo;
use \Karma\Entities\User;
use \Karma\Entities\Social;
use \Karma\Entities\ImportedTrack;
use \Karma\Entities\Track;
use \Session;
use \View;
use \Redirect;
use \Input;
use \Response;

class ImportController extends BaseController
{
    public function index()
    {
        $user = \KAuth::user();
        return View::make('import')->with('socials', $user->socials->keyBy('name'));
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
            $track = str_replace('_', ' ', $track);

            if($artist == "on")
                continue;
            $tmpArray = explode('|', $artist);
            $_track = array('title' => $track, 'artist' => $tmpArray[0], 'url'=>$tmpArray[1]);
            if (isset($tmpArray[2]))
                $_track['id'] = $tmpArray[2];
            else
                $_track['id'] = NULL;
            $tracks[] =  $_track;
        }

        foreach ($tracks as $track){
            $_track = MusicInfo::getTrackByArtistAndTitle($track['artist'], $track['title']);

            $params = array(
                'social_id' => Social::byName($provider)->id,
                'track_id' => $_track->id,
                'track_url' => $track['url'],
                'track_social_id' => $track['id']
            );
            $importedTrack = ImportedTrack::firstOrNew($params);
            if($importedTrack->exists == false){
                $importedTrack->save();
                $importedTrack->connectWithUser(Session::get('user_id'));
            }
        }
        return Redirect::action('profileIndex');
    }

    public function sync()
    {
        $user = User::find(Session::get('user_id'));
        $API = API::getAPI('vk');

        $userTracks = $user->tracks/*->toArray()*/;
        $serviceTracks = $API->getUserAudio();
        /*
         * TODO optimization?
         */


        foreach ($userTracks as $key => $userTrack){
            $found = false;
            foreach ($serviceTracks as $serviceTrack){
                if ($userTrack->track_social_id == $serviceTrack['aid'])
                    $found = true;
            }
            if ($found == false)
            {
                $userTracks->forget($key);
                $userTrack->delete();
            }
                
        }

        $importTracks = array();
        foreach ($serviceTracks as $serviceTrack){
            $found = false;
            foreach ($userTracks as $userTrack){
                if ($userTrack->track_social_id == $serviceTrack['aid'])
                    $found = true;
            }
            if ($found == false)
                $importTracks[] = $serviceTrack;
        }

        return View::make('importSelect')
            ->with('tracks', $importTracks)
            ->with('provider', 'vk');
    }

    public function importTrack($id)
    {
        $importTrack = ImportedTrack::find($id);
        $importTrack->connectWithUser(Session::get('user_id'));
        return Response::json(array('result' => 1));
    }

    public function importTrackFromDeezer($id)
    {
        $importTrack = ImportedTrack::firstOrNew(array('track_url' => $id));
        if($importTrack->exist == false){
            $deezerTrack = new \DeezerAPI\Models\Track($id);
            $track = MusicInfo::getTrackByArtistAndTitle($deezerTrack->artist->name, $deezerTrack->title, $deezerTrack->album);
            $importTrack = ImportedTrack::firstOrNew(array(
                'track_id' => $track->id,
                'social_id' => Social::byName('fb')->id,
                'track_url' => $id
            ));
            $importTrack->save();
            $importTrack->connectWithUser(Session::get('user_id'));
        }
    }
}