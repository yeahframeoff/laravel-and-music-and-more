@extends('layouts.main')

@section('content')

@if(isset($resultArray['artist']))
    Artists: <br/>
    @foreach($resultArray['artist'] as $artist)
        {{$artist->name}}
        <br/>
    @endforeach
    <br/>
@endif

@if(isset($resultArray['album']))
    Albums: <br/>
    @foreach($resultArray['album'] as $album)
        @include ('album_tile', ['album' => $album])
    @endforeach
    <br/>
@endif

@if(isset($resultArray['track']))
    Tracks: <br/>
    @foreach($resultArray['track'] as $track)
        @include ('track_tile', ['track' => $track, 'deezer' => true])
    @endforeach
@endif

@stop