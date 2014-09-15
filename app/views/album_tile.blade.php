<div class="album-tile">
    <h1>{{$album->title}}</h1>
    <div class="col-md-4">
        {{HTML::linkAction('Karma\Controllers\ImportController@importFromDeezerAlbum',
        'import as playlist',
        array('id' => $album->id))
        }}
        <img src="{{$album->cover}}" class="pull-left"/>
    </div>
    <div class="col-md-6">
        <div class="albumPlaylist pull-right">
            @foreach($album->tracks as $track)
            {{$track->title}}
            <br/>
            @endforeach
        </div>
    </div>
    <br/>

    <br/>
</div>