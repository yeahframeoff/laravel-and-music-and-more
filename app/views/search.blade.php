@extends('layouts.main')


@section('scripts')
@parent
{{ HTML::script('public/js/search.js') }}
@stop

@section('content')

<ul class="nav nav-pills">
    <li class="active"><a href="#people" data-toggle="pill">Люди</a></li>
    <li><a href="#music" data-toggle="pill">Музыка</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="people">
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

    <div class="tab-pane" id="music">
        <form class="input-group" action="{{ \URL::route('search.music') }}" id="form-audio-search">
            <input type="text" class="form-control" name="q" id="query-text">
            <span class="input-group-btn">
                <input class="btn btn-primary" type="submit" value="Search">
            </span>
        </form><!-- /input-group -->

        <div id="audio-fetched">

        </div>
        <div id="loading-span" hidden>
            <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>&nbsp;Loading...
        </div>
    </div>
</div>


<script id="search-user-template" type="text/template">
    @include ('user_tile_big', \Karma\Wrappers\UserTileWrapper::template())
</script>

<script id="search-audio-template" type="text/template">
    @include ('track_tile', \Karma\Wrappers\TrackTileWrapper::template())
</script>

<h2 id="nothing-found" hidden>Ничего не найдено:(</h2>

@stop

@section('player')
<div id="player-box">
    @include ('layouts.player', ['playClass' => 'play'])
</div>

@stop