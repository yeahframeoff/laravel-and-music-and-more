@extends('layouts.main')

@section('scripts')
@parent
    {{ HTML::script('public/js/groups.js') }}
@stop

@section('content')

@foreach(Karma\Entities\Genre::all() as $genre)
    {{HTML::linkAction('Karma\Controllers\GroupController@selectedGenre', $genre->name, array('id' => $genre->id))}}
@endforeach

<h1>Групы</h1>
{{HTML::linkAction('Karma\Controllers\GroupController@create', 'Create a group')}}

<div id="group-container">
    @foreach(KAuth::user()->myGroups as $group)
        <div class="group">
            <span class="group-name">
                {{HTML::linkAction('Karma\Controllers\GroupController@show', $group->name, array('id' => $group->id))}}
            </span>
            {{HTML::linkAction('Karma\Controllers\GroupController@edit', 'edit', array('id' => $group->id))}}
            {{ Form::open(array('action' => array('Karma\Controllers\GroupController@destroy', $group->id), 'method' => 'DELETE')) }}
                {{ Form::submit('delete', array('class' => 'btn btn-link')) }}
            {{ Form::close() }}
            <span class="group-genre">({{$group->genre->name}})</span>
            <br/>
            @if($group->avatar != NULL)
                <img src="{{$group->avatar}}"/>
            @endif
        </div>
    @endforeach
    @foreach($groups as $group)
        @if($group->founder_id != KAuth::getUserId())
            <div class="group">
                <span class="group-name">
                    {{HTML::linkAction('Karma\Controllers\GroupController@show', $group->name, array('id' => $group->id))}}
                </span>
                <span class="group-genre">({{$group->genre->name}})</span>
                <span class="group-active">
                    @if($group->active)
                        Online
                    @else
                        Offline
                    @endif
                </span>
                <br/>
                @if($group->avatar != NULL)
                    <img src="{{$group->avatar}}"/>
                @endif
            </div>
        @endif
    @endforeach
</div>

@stop
