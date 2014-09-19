@extends('layouts.main')

@section('content')
<div>
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
            {{--
            <a href="#" data-src="{{$track->track_url}}" data-cover="{{$track->track->albums->first()->artwork or ''}}"> {{$track->track->title}}</a>
            --}}
            @include('track_tile_rated', ['track' => $track])
        </li>
        @endforeach
    </ol>
</div>
@stop