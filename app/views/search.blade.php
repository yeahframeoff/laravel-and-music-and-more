@extends('layouts.main')

@section('content')
<?php
\HTML::macro('active', function($p, $w) { return $p == $w ? 'active' : ''; });
\HTML::macro('activeClass', function($p, $w) { return $p == $w ? 'class="active"' : ''; });
?>
@if (isset($result))
<ul class="nav nav-pills">
    <li {{ \HTML::activeClass($page, 'people') }}><a href="#people" data-toggle="pill">Люди</a></li>
    <li {{ \HTML::activeClass($page, 'music')  }}><a href="#music" data-toggle="pill">Музыка</a></li>
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
        @if ($page == 'people')
            @forelse($result as $user)
            @include ('user_tile_big', ['user' => $user])
            @empty
            <h2>Ничего не найдено:(</h2>
            @endforelse
        @endif
    </div>

    <div class="tab-pane {{ \HTML::active($page, 'music') }}" id="music">
        <form class="input-group" action="{{ \URL::route('search.music') }}">
            <input type="text" class="form-control" name="q">
            <span class="input-group-btn">
                <input class="btn btn-primary" type="submit" value="Search">
            </span>
        </form><!-- /input-group -->
        @if ($page == 'music')
            @forelse($result as $track)
                @include ('track_tile', ['track' => $track])
            @empty
            <h2>Ничего не найдено:(</h2>
            @endforelse
        @endif
    </div>
</div>
@stop