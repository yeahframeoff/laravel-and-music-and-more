@extends('layouts.main')

@section('content')

<h3>{{$artist->name}}</h3>

@foreach($artist->top as $track)
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

@stop