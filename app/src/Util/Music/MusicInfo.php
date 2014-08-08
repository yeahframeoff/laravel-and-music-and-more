<?php

namespace Karma\Util\Music;

use Dandelionmood\LastFm\LastFm;
use Guzzle\Http\Client;
use MusicBrainz\HttpAdapters\GuzzleHttpAdapter;
use MusicBrainz\MusicBrainz;

/**
 * This class provides access to different music information using online resources such as MusicBrainz and Last.fm
 **/ 
class MusicInfo
{
    protected static $lastfm;
    protected static $brainz;
    
    static function init()
    {
        self::$lastfm = new LastFm;
        self::$brainz = new MusicBrainz(new GuzzleHttpAdapter(new Client()));
    }
    
    /**
     * @param string $artist
     * @param string $title
     * @return array
     */
    public static function getTrackInfo($artist, $title)
    {
        $_artist = Artist::where('name', $artist);
        
        if($_artist->exists())
        {
            $_track = Track::where('artist_id', $_artist->id)
                           ->where('title', $title);
            
            if($_track->exists())
            {
                
            }
            else
            {
                
            }            
        }
        else
        {
            
        }
        
        $result['album'] = self::getAlbumInfo($album);
        $result['artist'] = self::getArtistInfo($artist);
        $result['lyrics'] = self::getLyrics(array($artist, $title));        
        
        return $result;
    }
    
    /**
     * @param string $album
     * @return array
     */
    public static function getAlbumInfo(string $album)
    {
        
    }
    
    /**
     * @param string $artist
     * @return array
     */
    public static function getArtistInfo($artist)
    {
        
    }
}

MusicInfo::init();