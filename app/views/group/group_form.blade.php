@extends('layouts.main')
@section('content')

@if(isset($group))
    {{ Form::model($group, array('action' => array('Karma\Controllers\GroupController@update', $group->id), 'method' => 'PUT')) }}
@else
    {{ Form::open(array('action' => 'Karma\Controllers\GroupController@store')) }}
@endif

<div class="form-group">
    {{ Form::label('name', 'Name') }}
    {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('genre', 'Genre') }}
    {{ Form::text('genre', Input::old('genre'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('desc', 'Description') }}
    {{ Form::textArea('desc', Input::old('desc'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('avatar', 'Avatar(URL)') }}
    {{ Form::text('avatar', Input::old('avatar'), array('class' => 'form-control')) }}
</div>

@if(!isset($group))
    @foreach($tracks as $track)
        <strong>{{$track->track->artist->name}}</strong> - {{$track->track->title}}
        <input type="checkbox" name="{{$track->id}}" value="{{$track->id}}">
        <br/>
    @endforeach
@endif

{{ Form::submit('Save the group', array('class' => 'btn btn-primary')) }}
{{ Form::close() }}

@stop