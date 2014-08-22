@extends('layouts.main')
@section('content')
@if(isset($playlist))
    {{ Form::model($playlist, array('action' => array('Karma\Controllers\LibraryController@update', $playlist->id), 'method' => 'PUT')) }}
@else
    {{ Form::open(array('action' => 'Karma\Controllers\LibraryController@store')) }}
@endif

    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
    </div>

<?php
    /*
     * TODO optimization
     */
?>
    @if(isset($playlist))
        @foreach($playlist->tracks as $track)
            <strong>{{$track->track->artist->name}}</strong> - {{$track->track->title}}
            <input type="checkbox" name="{{$track->id}}" value="{{$track->id}}" checked>
            <br/>
        @endforeach
    @endif

    @foreach($tracks as $track)
        <strong>{{$track->track->artist->name}}</strong> - {{$track->track->title}}
        <input type="checkbox" name="{{$track->id}}" value="{{$track->id}}">
        <br/>
    @endforeach

    {{ Form::submit('Create the playlist', array('class' => 'btn btn-primary')) }}
{{ Form::close() }}

@stop