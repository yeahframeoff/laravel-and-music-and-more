<?php
try{
?>

    <h1>{{$album->title}}</h1>
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