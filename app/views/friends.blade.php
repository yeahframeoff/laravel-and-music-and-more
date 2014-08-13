@extends('layouts.main')

@section('scripts')
@parent
{{ HTML::script('public/js/friends.js') }}
@stop

@section('content')
@foreach($friends as $friend)
    @include ('user_tile', [
        'user'    => $friend,
        'current' => $current_user,
    ])
    
@endforeach
@stop