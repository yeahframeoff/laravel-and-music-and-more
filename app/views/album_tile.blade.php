<div class="album-tile">
    <h1>{{$album->title}}</h1>
    <div class="col-md-4">
        {{HTML::linkAction('Karma\Controllers\ImportController@importFromDeezerAlbum',
        'import as playlist',
        array('id' => $album->id))
        }}
        <img src="{{$album->cover}}" class="pull-left"/>
    </div>
    <div class="col-md-8">
            <ol class="musicList">
                <?php $count = count($album->tracks); $count = ($count > 5) ? 5 : $count; $album->tracks = array_slice($album->tracks, 0, $count); ?>
                @foreach($album->tracks as $track)
                    <li class="musicPlayer li">
                        <a href="#"
                           data-src="{{$track->id}}"
                           data-cover="">
                            <strong>{{ $track->artist->name }}</strong>&nbsp;-&nbsp;{{ $track->title }}
                        </a>
                        &nbsp;
                        <a href="#" class="addTrack" data-id="{{$track->id}}" deezer="1">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a>
                    </li>
                @endforeach
            </ol>
    </div>
    <br/>

    <br/>
</div>