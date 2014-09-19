<?php

namespace Karma\Wrappers;

use Karma\Util\FriendButtonComposer;

class TrackTileWrapper extends AbstractWrapper
{
    public function wrap_single($track)
    {
        if(isset($deezer))
            $albums = array($track->album->title);
        else{
            $albums = array();
            foreach ($track->albums as $album)
                $albums[] = $album->name;
        }
        return array(
            'importedTrack' => !isset($importedTrack) ? false : $importedTrack,
            'trackUrl' => $track->track_url,
            'trackCover' => $track->track->albums->first()->artwork || '',
            'trackArtistName' => $track->artist->name,
            'trackTitle' => $track->title,
            'trackId' => $track->id,
            'isSetDeezer' => isset($deezer),
            'importedTrackUrl' => $track->importedTrack->track_url,
            'importedTrackCover' => $track->albums->first()->artwork or '',
            'importedTrackId' => $track->importedTrack->id,
            'isNotEmptyAlbums' => !empty($albums),
            'albumss' => !empty($albums) ? implode (', ', $albums) : null,
        );
    }

    public function template_single()
    {
        return array(
            'importedTrack' => '<%= importedTrack %>',
            'trackUrl' => '<%= trackUrl %>',
            'trackCover' => '<%= trackCover %>',
            'trackArtistName' => '<%= trackArtistName %>',
            'trackTitle' => '<%= trackTitle %>',
            'trackId' => '<%= trackId %>',
            'isSetDeezer' => '<%= isSetDeezer %>',
            'importedTrackUrl' => '<%= importedTrackUrl %>',
            'importedTrackCover' => '<%= importedTrackCover %>',
            'importedTrackId' => '<%= importedTrackId %>',
            'isNotEmptyAlbums' => '<%= isNotEmptyAlbums %>',
            'albumss' => '<%= albumss %>',
        );
    }
}