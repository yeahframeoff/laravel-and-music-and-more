@extends('layouts.main')

@section('scripts')
@parent
    {{ HTML::script('public/js/groups.js') }}
@stop

@section('content')

Filter by genre:
@foreach(Karma\Entities\Genre::all() as $genre)
    {{HTML::linkAction('Karma\Controllers\GroupController@selectedGenre', $genre->name, array('id' => $genre->id))}}
@endforeach

<h1>Группы</h1>
{{HTML::linkAction('Karma\Controllers\GroupController@create', 'Create a group')}}

<div id="group-container">
    @foreach($groups as $group)
            <div class="group">
                <span class="group-name">
                    {{HTML::linkAction('Karma\Controllers\GroupController@show', $group->name, array('id' => $group->id))}}
                </span>
                @if($group->founder_id == KAuth::getUserId())
                    <div class="btn-group pull-right">
                        <a href="{{URL::route('groups.edit', ['group' => $group->id])}}"
                           data-method="get"
                           class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit
                        </a>
                        <a href="{{URL::route('groups.destroy', ['group' => $group->id])}}"
                           data-method="delete"
                           class="btn btn-danger btn-sm please-work-http-delete-button">
                            <span class="glyphicon glyphicon-remove"></span>&nbsp;Delete
                        </a>
                    </div>
                @endif
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
    @endforeach
</div>

@stop
