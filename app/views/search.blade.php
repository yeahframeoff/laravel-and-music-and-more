@extends('layouts.main')

@section('content')
<?php
\HTML::macro('active', function($p, $w) { return $p == $w ? 'active' : ''; });
\HTML::macro('activeClass', function($p, $w) { return $p == $w ? 'class="active"' : ''; });
?>
@if (isset($requests))
<ul class="nav nav-pills">
    <li {{ \HTML::activeClass($page, 'people') }}><a href="#people" data-toggle="pill">Люди</a></li>

    {{--
    <li><a href="#requests" data-toggle="pill">
            Заявки
            &nbsp;
            @if($count = \Karma\Auth\OAuth::getUser()->friendshipRequestsCount() > 0 )
            <span class="badge">+{{$count}}</span>
            @endif
        </a>
    </li>
    --}}

</ul>
@endif


<div class="tab-content">
    <div class="tab-pane {{ \HTML::active($page, 'people') }}" id="people">
        <form class="input-group" action="{{ \URL::route('search.people') }}">
            <input type="text" class="form-control" name="q">
            <span class="input-group-btn">
                <input class="btn btn-primary" type="submit" value="Search">
            </span>
        </form><!-- /input-group -->
        @forelse($result as $user)
        @include ('user_tile_big', ['user' => $user])
        @empty
        <h2>Ничего не найдено(</h2>
        @endforelse
    </div>

    {{--
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
    --}}
</div>
@stop