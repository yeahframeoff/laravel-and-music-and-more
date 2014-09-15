@extends('layouts.main')

@section('content')

@if(isset($resultArray['artist']))
    Artists: <br/>
    @foreach(array_slice($resultArray['artist'], 0, 10) as $artist)
        {{HTML::linkAction('Karma\Controllers\SearchController@artistPage',
            $artist->name,
            array('id' => $artist->id))
        }}
        <br/>
    @endforeach
    <br/>
@endif

@if(isset($resultArray['album']))
    <div class="row">
        Albums: <br/>
        @foreach($resultArray['album'] as $key=>$album)
            <div class="col-md-5">
                @include ('album_tile', ['album' => $album])
            </div>
        @endforeach
        <br/>
    </div>
@endif

@if(isset($resultArray['track']))
    Tracks: <br/>
    @foreach($resultArray['track'] as $track)
        @include ('track_tile', ['track' => $track, 'deezer' => true])
    @endforeach
@endif

@stop