@extends('layouts.main')

@section('stylesheets')
    {{ HTML::style('public/css/player.css') }}
    @parent
@stop

@section('content')
<div style="margin: auto 0;">
    <span class="glyphicon glyphicon-user"></span>&nbsp;
    <h1 style="display: inline;">{{ $user->first_name . ' ' . $user->last_name  }}</h1>

</div>

<hr>
<div class="row">
    <div class="col-md-6">
        @include ('profile.icon_span', ['user' => $user])
        @include ('profile.audio_span', ['user' => $user])
    </div>

    <div class="col-md-6">
        @include ('profile.friends_span', ['user' => $user])
        <hr>
        @include ('profile.groups_span', ['user' => $user])
        <hr>
        @include ('profile.feed_span', ['posts' => $user->receivedPosts])
    </div>
</div>

@stop

@section('player')
<div id="player-box">
    @include ('layouts.player', ['playClass' => 'play'])
</div>
@stop