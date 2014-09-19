@extends('layouts.main')

@section('scripts')
@parent
{{ HTML::script('public/js/search.js') }}
@stop

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
        <form class="input-group" action="{{ \URL::route('search.people') }}" id="form-people-search">
            <input type="text" class="form-control" name="q" id="query-text">
            <span class="input-group-btn">
                <input class="btn btn-primary" type="submit" value="Search">
            </span>
        </form><!-- /input-group -->
        <div id="people-fetched">

        </div>
        <div id="loading-span" hidden>
            <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>&nbsp;Loading...
        </div>
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

<script id="search-user-template" type="text/template">
    @include ('user_tile_big', \Karma\Wrappers\UserTileWrapper::template())
</script>
<h2 id="nothing-found" hidden>Ничего не найдено:(</h2>
@stop