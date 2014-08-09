<?php

namespace Karma\Util;

use Dandelionmood\LastFm\LastFm;
use Guzzle\Http\Client;
use MusicBrainz\HttpAdapters\GuzzleHttpAdapter;
use MusicBrainz\MusicBrainz;
use MusicBrainz\Filters\ArtistFilter;
use MusicBrainz\Filters\RecordingFilter;
use Karma\Entities\Artist;
use Karma\Entities\Track;
use Karma\Entities\Genre;

/**
 * This class provides access to different music information using online resources such as MusicBrainz and Last.fm
 **/ 
class MusicInfo
{
    protected static $lastfm;
    
    static function init()
    {
        $lastfm_api_key = 'ccbc93e11dffaa72a00e07794bb7f80b';
        $lastfm_api_secret = '9c3d9395a082ac11c5f2e11a82df1f86';
        
        self::$lastfm = new LastFm($lastfm_api_key, $lastfm_api_secret);
    }
    
    /**
     * @param string $artist
     * @param string $title
     * @return array
     */
    public static function getTrackByArtistAndTitle($artist, $title)
    {
        $_artist = Artist::where('name', $artist);
        
        if(!$_artist->exists())
        {
            $_artist = new Artist;
            
            $info = self::getArtistInfo($artist)->artist;
            
            if(!empty($info))
            {
                $_artist->name = $info->name;
            	$_artist->bio  = $info->bio->summary;
            }
            else
            {
                $_artist->name = $artist;
                $_artist->bio = 'Не доступна.';
            }
            
            $_artist->save();
        }
       	else
        {
            $_artist = $_artist->get()->first();
        }
        
        $_track = Track::where('artist_id', $_artist->id)
                       ->where('title', $title);
        
        if(!$_track->exists())
        {
            $_track = new Track;
            
            $_track->artist_id = $_artist->id;
            
            $args = array('track' => $title,
                          'artist' => $_artist->name,
                          'autocorrect' => true);
        
            $info = self::$lastfm->track_getInfo($args)->track;
            
            if(!empty($info))
            {
                $_track->title = $info->name;
                $_genre = Genre::where('name', $info->toptags->tag[0]->name);
                
                if(!$_genre->exists())
                {
                    $_genre = new Genre;
                    $_genre->name = $info->toptags->tag[0]->name;
                    $_genre->save();
                }
                
                $_track->genre_id = $_genre->id;
                $_track->lyrics = 'not available';//TODO
            }
            else
            {
                $_track->title = $title;
                $_track->lyrics = 'Текст песни недоступен.';
            }

        	$_track->save();   
        }
        else
        {
            $_track = $_track->first();
        }           
        
        return $_track;
    }
    
    /**
     * @param string $album
     * @return object
     */
    public static function getAlbumInfo(string $album)
    {
        $args = array('album' => $album,
                      'autocorrect' => true,
                      'lang' => 'ru');
        
        return self::$lastfm->album_getInfo($args);
    }
    
    /**
     * @param string $artist
     * @return object
     */
    public static function getArtistInfo($artist)
    {
        $args = array('artist' => $artist,
                      'autocorrect' => true,
                      'lang' => 'ru');
        
        return self::$lastfm->artist_getInfo($args);
    }
}

MusicInfo::init();