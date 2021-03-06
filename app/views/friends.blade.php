@extends('layouts.main')

@section('content')
@if (isset($requests))
<ul class="nav nav-pills">
    <li @unless ($showRequests)class="active" @endunless><a href="#friends" data-toggle="pill">Мои друзья</a></li>
    <li @if ($showRequests)class="active" @endif><a href="#requests" data-toggle="pill">
        Заявки
        &nbsp;
        @if($count = \KAuth::user()->friendshipz()->requests()->count() > 0 )
        <span class="badge">+{{$count}}</span>
        @endif
        </a>
    </li>
    
</ul>
@endif


<div class="tab-content">
    <div class="tab-pane @unless ($showRequests) active @endunless" id="friends">
        <div class="page-header">
            @if ($user->id == \KAuth::getUserId())
            <h1>Ваши друзья</h1>
            @else
            <h1>Друзья пользователя {{ $user->first_name . ' ' . $user->last_name }}</h1>
            @endif
        </div>
        @forelse($friends as $friend)
            @include ('user_tile_big', ['user' => $friend])
        @empty
            @if ($user->id == \KAuth::getUserId())
            <h2>У вас пока что нет друзей :(</h2>
            @else
            <h2>У пользователя
                <a href="{{ URL::route('profile', ['user' => $user->id])}}">
                    {{ $user->first_name . ' ' . $user->last_name }}</a>
                пока что нет ни одного друга :(
            </h2>
            @endif
        @endforelse
    </div>

    @if (isset($requests))
        <div class="tab-pane @if ($showRequests) active @endif" id="requests">
            <div class="page-header">
                <h1>Заявки в друзья</h1>
            </div>
        @forelse($requests as $request)
            @include ('user_tile_big', [
                'user'    => $request->user,
                'current' => $current_user,
            ])

        @empty
            <h2>К сожалению, нет новых заявок в друзья.</h2>
        @endforelse
        </div>
    @endif
</div>
@stop