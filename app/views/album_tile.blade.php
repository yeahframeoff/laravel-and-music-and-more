<?php
try{
?>

    <h1>{{$album->title}}</h1>
    {{HTML::linkAction('Karma\Controllers\ImportController@importFromDeezerAlbum',
        'import as playlist',
        array('id' => $album->id))
    }}
    <img src="{{$album->cover}}" class="pull-left"/>
    <div class="albumPlaylist">
        @foreach($album->tracks as $track)
            {{$track->title}}
        <br/>
        @endforeach
    </div>
    <br/>

<?php
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
?>

<br/>