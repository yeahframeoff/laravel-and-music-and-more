<?php

namespace Karma\Util;

use Dandelionmood\LastFm\LastFm;
use Karma\Entities\Artist;
use Karma\Entities\Track;
use Karma\Entities\Genre;
use \DeezerAPI;
use \DeezerAPI\Models\Album;

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

            $info;
            try{
                $info = self::$lastfm->track_getInfo($args)->track;
                $_track->title = $info->name;

                if (!isset($info->toptags->tag[0]->name))
                    $genre = 'unknown';
                else
                    $genre = $info->toptags->tag[0]->name;

                $_genre = Genre::where('name', $genre)->first();

                if($_genre == NULL)
                {
                    $_genre = new Genre;
                    $_genre->name = $genre;
                    $_genre->save();
                }

                $_track->genre_id = $_genre->id;
                $_track->lyrics = 'not available';//TODO
            } catch (\Exception $e) {
                $_track->title = $title;
                $_track->genre_id = Genre::where('name', 'unknown')->first()->id;
                $_track->lyrics = 'not available';
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
    public static function getAlbumInfo($album)
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
    
    
    /**
     * @param string $artist
     * @return object
     */
    public static function getArtistAlbums($artist)
    {
        $search = new DeezerAPI\Search($artist, 'artist', 'DURATION_DESC');
        $result = $search->search();
        foreach ($result as $_artist){
            if($_artist->name == $artist){
                return $_artist->albums;
            }
        }
        /*
         * TODO make the view with list of artists, where user can choose the correct one.
         */
    }
}

MusicInfo::init();