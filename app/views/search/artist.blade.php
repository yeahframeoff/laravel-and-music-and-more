@extends('layouts.main')

@section('content')

<h3>{{$artist->name}}</h3>

@foreach($artist->top as $track)
    @include ('track_tile', ['track' => $track, 'deezer' => true])
@endforeach

@stop