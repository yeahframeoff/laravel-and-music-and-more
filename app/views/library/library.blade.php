@extends('layouts.main')
@section('content')
<ul class="nav nav-pills">
    <li class="active"><a href="#all" data-toggle="pill">Все треки</a></li>
    <li><a href="#playlists" data-toggle="pill">Плейлисты</a></li>
</ul>


<div class="tab-content">
    <div class="tab-pane active" id="all">
        <div class="page-header">
            <h1>Все треки</h1>
        </div>

        <audio preload></audio>
        <div id="dz-root"></div>
        <ol>
            @foreach($tracks as $track)
                <li>
                    <a href="#" data-src="{{$track->track_url}}"> {{$track->track->title}}</a>
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
                <a href="#">{{$playlist->name}}</a>
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