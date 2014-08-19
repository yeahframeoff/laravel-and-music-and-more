@extends('layouts.main')

@section('scripts')
@parent
{{ HTML::script('public/js/friends.js') }}
@stop

@section('content')
@if (isset($requests))
<ul class="nav nav-pills">
    <li class="active"><a href="#friends" data-toggle="pill">Мои друзья</a></li>
    
        <li><a href="#requests" data-toggle="pill">
            Заявки
            &nbsp;
            @if($count = \Karma\Auth\OAuth::getUser()->friendshipRequestsCount() > 0 )
            <span class="badge">+{{$count}}</span>
            @endif
            </a>
        </li>
    
</ul>
@endif


<div class="tab-content">
    <div class="tab-pane active" id="friends">
        <div class="page-header">
            @if ($user->id == $current_user->id)
            <h1>Ваши друзья</h1>
            @else
            <h1>Друзья пользователя {{ $user->first_name . ' ' . $user->last_name }}</h1>
            @endif
        </div>
        @forelse($friends as $friend)
            @include ('user_tile_big', [
                'user'    => $friend,
                'current' => $current_user,
            ])
        @empty    
            <h2>У вас пока что нет друзей :(</h2>
        @endforelse
    </div>

    @if (isset($requests))
        <div class="tab-pane" id="requests">
            <div class="page-header">
                <h1>Заявки в друзья</h1>
            </div>
        @forelse($requests as $friend)
            @include ('user_tile_big', [
                'user'    => $friend,
                'current' => $current_user,
            ])

        @empty
            <h2>К сожалению, нет новых заявок в друзья.</h2>
        @endforelse
        </div>
    @endif
</div>
@stop