@extends('layouts.main')

@section('content')
<ul class="nav nav-pills">
    <li class="active"><a href="#all" data-toggle="pill">Все треки</a></li>
    <li><a href="#playlists" data-toggle="pill">Плейлисты</a></li>
</ul>


<div class="tab-content">
    <div class="tab-pane active" id="all">
        <div class="page-header">
            @if(isset($playlist))
                <h1>{{$playlist->name}}</h1>
            @else
                <h1>Все треки</h1>
            @endif
        </div>

        @if(count($tracks) > 0)
            @include ('layouts.player', ['playClass' => 'play'])
        @endif


        <br/>
        <ol class="musicList">
            @foreach($tracks as $track)
            <li class="musicPlayer li">
                <a href="#" data-src="{{$track->track_url}}" data-cover="{{$track->track->albums->first()->artwork or ''}}"> {{$track->track->title}}</a>
            </li>
            @endforeach
        </ol>
    </div>

    <div class="tab-pane" id="playlists">
        <div class="page-header">
            <h1>Плейлисты</h1>
            {{HTML::linkAction('Karma\Controllers\LibraryController@create', 'Create a playlist')}}
        </div>
        
        @foreach($playlists as $playlist)
            <div class="playlist">
                {{HTML::linkAction('Karma\Controllers\LibraryController@show', $playlist->name, array('id' => $playlist->id))}}
                {{HTML::linkAction('Karma\Controllers\LibraryController@edit', 'edit', array('id' => $playlist->id))}}
                <div class="playlist-tracks">
                    @foreach($playlist->tracks as $track)
                        {{$track->track->title}}<br>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@stop