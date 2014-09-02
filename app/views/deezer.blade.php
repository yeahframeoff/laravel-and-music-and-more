@extends('layouts.main')

@section('content')

Artists: <br/>
@foreach($resultArray['artist'] as $artist)
    {{$artist->name}}
    <br/>
@endforeach
<br/>

Albums: <br/>
@foreach($resultArray['album'] as $album)
    @include ('album_tile', ['album' => $album])
@endforeach
<br/>

Tracks: <br/>
@foreach($resultArray['track'] as $track)
    @include ('track_tile', ['track' => $track, 'deezer' => true])
@endforeach

@stop