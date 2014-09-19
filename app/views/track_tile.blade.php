<h5>
    <?php if(!isset($importedTrack)) $importedTrack = false; ?>
    @if($importedTrack == true)
        <a href="#"
           data-src="{{$track->track_url}}"
           data-cover="{{$track->track->albums->first()->artwork or ''}}">
            <strong>{{ $track->artist->name }}</strong>&nbsp;-&nbsp;{{ $track->title }}
        </a>
        &nbsp;
        <a href="#" class="addTrack" data-id="{{$track->id}}" deezer="{{isset($deezer)}}">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    @else
        <a href="#"
           data-src="{{$track->importedTrack->track_url}}"
           data-cover="{{$track->albums->first()->artwork or ''}}">
            <strong>{{ $track->artist->name }}</strong>&nbsp;-&nbsp;{{ $track->title }}
        </a>
        &nbsp;
        <a href="#" class="addTrack" data-id="{{$track->importedTrack->id}}" deezer="{{isset($deezer)}}">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    @endif

    <?php
    if(isset($deezer))
        $albums = array($track->album->title);
    else{
        $albums = array();
        foreach ($track->albums as $album)
            $albums[] = $album->name;
    }
    ?>
    @if (!empty($albums))({{ implode (', ', $albums) }}) @endif
</h5>