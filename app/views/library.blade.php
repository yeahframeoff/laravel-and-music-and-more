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
        
        @foreach($tracks as $track)
            $track->track_url<br>
        @endforeach
    </div>

    <div class="tab-pane" id="playlists">
        <div class="page-header">
            <h1>Плейлисты</h1>
        </div>
        
        @foreach($playlists as $playlist)
            <div class="playlist">
                <a href="#">$playlist->name</a>
                <div class="playlist-tracks">
                    @foreach($playlist->tracks() as $track)
                        $track->track_url
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@stop