@extends('layouts.main')

@section('scripts')
@parent
{{ HTML::script('public/js/friends.js') }}
@stop

@section('content')
<div class="page-header">
    @if ($user->id == $current_user->id)
    <h1>ваши друзья</h1>
    @else
    <h1>друзья пользователя {{ $user->first_name . ' ' . $user->last_name }}</h1>
    @endif
</div>
@foreach($friends as $friend)
    @include ('user_tile_big', [
        'user'    => $friend,
        'current' => $current_user,
    ])
    
@endforeach
@stop