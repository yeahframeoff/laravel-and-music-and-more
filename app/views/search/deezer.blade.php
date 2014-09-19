@extends('layouts.main')

@section('content')

<h2>Result of search {{$q}}: </h2>

@if(isset($resultArray['album']))
    <div class="row">
        Albums: <br/>
        @foreach($resultArray['album'] as $key=>$album)
            <div class="col-md-6">
                @include ('album_tile', ['album' => $album])
            </div>
        @endforeach
        <br/>
    </div>
@endif

@if(isset($resultArray['track']))
    Tracks: <br/>
    <ol class="musicList">
        @foreach($resultArray['track'] as $track)
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
@endif

@stop

@section('player')
<div id="player-box">
    @include ('layouts.player', ['playClass' => 'play'])
</div>
@stop