<?php

namespace Karma\Controllers;

use \Karma\API\API;
use \Karma\Util\MusicInfo;
use \Karma\Entities\User;
use \Karma\Entities\Social;
use \Karma\Entities\ImportedTrack;
use \Session;
use \Redirect;

class ImportController extends BaseController
{
    public function index()
    {
        return \View::make('import')->with('socials', \Karma\Entities\User::find(\Session::get('user_id'))->socials());
    }
    
    public function import($provider)
    {
        $API = API::getAPI($provider);
        
        $tracks = $API->getUserAudio();
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
        //return Redirect::action('profileIndex');
    }
}