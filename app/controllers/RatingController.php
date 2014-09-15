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
        $class = 'Karma\Entities\\' . ($objtype == 'track' ? 'Track' : 'Playlist');
        $id = Input::get('id');
        $obj = $class::with('rates')->find($id);
        if ($rate = $obj->rates()->where('rater_id', '=', KAuth::getUserId())->first() === null)
            $rate = new Rate;
        $rate->value = Input::get('value', 5);
        $obj->rates()->save($rate);
    }

    public function loadRates()
    {
        $objs = Input::get('objects', '');
//        $tracks = Input::get('tracks');
//        $playlists = Input::get('playlists');

//        \Log::info($tracks);
//        \Log::info($playlists);

        $data = [
            'track'    => [],
            'playlist' => []
        ];
//        \Log::info("\n");
        foreach($objs as $object)
        {
//            \Log::info($object);
//            json_decode($object, true);
            if ($object['type'] == 'track')
                $data['track'][] = $object['id'];
            else
                $data['playlist'][] = $object['id'];
        }
//        \Log::info("\n");
//        die();
        $tracks = Karma\Entities\Track::whereIn('id', $data['track'])
                                      ->with('rates')->get();
        $playlists = Karma\Entities\Playlists::whereIn('id', $data['playlist'])
                                             ->with('rates')->get();

        $response = [
            'track' => [],
            'playlist' => []
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