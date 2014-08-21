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
            if (isset($tmpArray[2]))
                $_track['id'] = $tmpArray[2];
            else
                $_track['id'] = NULL;
            $tracks[] =  $_track;
        }

        foreach ($tracks as $track){
            /*
             * TODO try to musicInfo???
             */
            try {
                $_track = MusicInfo::getTrackByArtistAndTitle($track['artist'], $track['title']);
            } catch (\Exception $e) {
                continue;
            }
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

        $userTracks = $user->tracks->toArray();
        $serviceTracks = $API->getUserAudio();
        /*
         * TODO optimization?
         */


        foreach ($userTracks as $userTrack){
            $found = false;
            $foundImport = false;
            foreach ($serviceTracks as $serviceTrack){
                if ($userTrack['track_social_id'] == $serviceTrack['aid'])
                    $found = true;
            }
            if ($found == false)
                ImportedTrack::find($userTrack['id'])->delete();
        }

        $importTracks = array();
        foreach ($serviceTracks as $serviceTrack){
            $found = false;
            foreach ($userTracks as $userTrack){
                if ($userTrack['track_social_id'] == $serviceTrack['aid'])
                    $found = true;
            }
            if ($found == false)
                $importTracks[] = $serviceTrack;
        }

        return View::make('importSelect')
            ->with('tracks', $importTracks)
            ->with('provider', 'vk');
    }
}