<h3><strong>{{ $track->artist->name }}</strong>&nbsp;-&nbsp;{{ $track->title }}&nbsp;
    <a href="#" class="addTrack" data-id="{{$track->id}}" deezer="{{isset($deezer)}}">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
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
</h3>
<hr>