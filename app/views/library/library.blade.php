@extends('layouts.main')

@section('stylesheets')
    {{ HTML::style('public/css/player.css') }}
    @parent
@stop

@section('scripts')
    @parent
    {{ HTML::script('public/js/audioController.js') }}
@stop

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
        <div class="musicPlayer">
            <h1>Demo - Preview Song</h1>
            <img class="cover" src="/public/images/empty.png">
            <div class="play">
                <button title="play/pause"></button>
            </div>
            <div class="mute">
                <button title="mute/unmute"></button>
            </div>
            <div class="volume-slider">
                <div class="volume-total"></div>
                <div class="volume-current"></div>
            </div>
            <div class="time-rail">
                <span class="time-total">
                    <span class="time-loaded"></span>
                    <span class="time-current"></span>
                </span>
            </div>
        </div>
        <input type="button" class="prev" value="prev"/>
        <input type="button" class="next" value="next"/>
        @endif


        <br/>
        <div id="dz-root"></div>
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