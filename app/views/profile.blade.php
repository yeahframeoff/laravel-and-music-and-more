@extends('layouts.main')
@section('content')
<div style="margin: auto 0;">
    <span class="glyphicon glyphicon-user"></span>&nbsp;
    <h1 style="display: inline;">{{ $user->first_name . ' ' . $user->last_name  }}</h1>
</div>

<hr>

<div class="row">
    <div class="col-md-6">
        <h2></h2>
    	{{ HTML::image($user->photo, $user->first_name . ' ' . $user->last_name, array('title' => $user->first_name . ' ' . $user->last_name, 'class' => 'img-thumbnail')) }}
    </div>
    
    <div class="col-md-6">
        <h2>Друзья</h2>
        <hr>
        
        @for ($i = 0; $i < count($user->friends()); $i++)
            @if($i % 3 == 0)
                <span class="terminator"></span>
            @endif

            <div class="tile-3 square">
                <a href="{{ URL::route('profile', array('user' => $user->friends()[$i]->id)) }}">
                   {{ HTML::image($user->friends()[$i]->photo, $user->friends()[$i]->first_name . ' ' . $user->friends()[$i]->last_name, array('title' => $user->friends()[$i]->first_name . ' ' . $user->friends()[$i]->last_name, 'class' => 'img-thumbnail')) }}
                </a>
            </div>
        @endfor
    </div>
</div>

<div class="row">
    <div class="col-md-6 center-block">
        <h2>Группы</h2>
        <hr>

    </div>
</div>
@stop