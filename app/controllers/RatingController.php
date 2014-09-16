<?php

namespace Karma\Controllers;

use \Input;
use \KAuth;
use Karma\Entities\Rate;
use Response;

class RatingController extends BaseController
{
    public function rate()
    {
        if (! Input::has('type') || ! Input::has('id'))
            return Response::json(['error' => 'invalid request']);
        $objtype = Input::get('type');
        $id = Input::get('id');
        $value = Input::get('value', 5);

        KAuth::user()->rate(['type' => $objtype, 'id' => $id], $value);
    }

    public function loadRates()
    {
        $tracks = Input::get('tracks', array());
        $playlists = Input::get('playlists', array());

        if (! empty ($tracks))
            $tracks = \Karma\Entities\Track::whereIn('id', $tracks)->with('rates')->get();
        if (! empty ($playlists))
            $playlists = \Karma\Entities\Playlist::whereIn('id', $playlists)->with('rates')->get();

        $response = [
            'track' => array(),
            'playlist' => array()
        ];
        foreach (['track' => $tracks, 'playlist' => $playlists] as $type => $list)
            foreach ($list as $entry)
            {
                $entryData = array();
                $entryData['id'] = $entry->id;
                $entryData['type'] = $type;
                $entryData['avg'] = $entry->rates()->avg('value');
                $entryData['count'] = $entry->rates()->count();
                $userRate = $entry->rates()->where('rater_id', '=', KAuth::getUserId())->first();
                $entryData['userRate'] = $userRate === null ? null : $userRate->value;
                $response[$type][] = $entryData;
            }

        return Response::json($response);
    }
} 