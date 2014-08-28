@extends('layouts.main')

@section('stylesheets')
    {{ HTML::style('public/css/player.css') }}
    @parent
@stop

@section('scripts')
    @parent
    {{ HTML::script('public/js/audioController.js') }}
@stop

@section('content')
<div style="margin: auto 0;">
    <span class="glyphicon glyphicon-user"></span>&nbsp;
    <h1 style="display: inline;">{{ $user->first_name . ' ' . $user->last_name  }}</h1>

</div>

<hr>

<div class="row">
    <div class="col-md-6">

    	{{  HTML::image(
                $user->photo,
                $user->first_name . ' ' . $user->last_name,
                [
                    'title' => $user->first_name . ' ' . $user->last_name,
                    'class' => 'img-thumbnail',
                ]
        ) }}

        <hr>
    </div>
    
    <div class="col-md-6">
        <a class="h2" href="{{ \URL::route('friends', ['user' => $user->id]) }}">Друзья</a>
        <hr>
        
        @foreach ($user->friends() as $i => $friend)
            @if($i % 3 == 0)
                <span class="terminator"></span>
            @endif

            <div class="tile-3 square">
                <a href="{{ URL::route('profile', array('user' => $friend->id)) }}">
                    {{  HTML::image(
                            $friend->photo,
                            $friend->first_name . ' ' . $friend->last_name, 
                            [
                                'title' => $friend->first_name . ' ' . $friend->last_name,
                                'class' => 'img-thumbnail'
                            ]
                    ) }}
                </a>
            </div>
        @endforeach
    </div>
</div>

<div class="row">
    <div class="col-md-6">
            <br>
    	@if($user->id != KAuth::getUserId())
            @include ('friendship_button', ['user' => $user])
        @else
            <div class="btn-group">
                @foreach ($user->credentials as $cr)
                    <a class="btn" href="{{ URL::route('profile.load', ['name' => $cr->social->name]) }}">
                    <img src="{{ $cr->social->iconUrl() }}">
                    {{ $cr->social->title }} @if($cr) <span class="glyphicon glyphicon-ok"></span>@endif
                    </a>
                @endforeach

            </div>
        
            <div class="dropdown">
                <a href="#" class="dropdown-toggle btn" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-plus"></span>
                    <b class="caret"></b>
                </a>
                
                <ul class="dropdown-menu">

                    @foreach(Karma\Entities\Social::all() as $sn )
                        @unless ($user->socials()->get()->contains($sn))
                        <li><a href="{{URL::route('auth.connect', ['provider' => $sn->name])}}">{{ $sn->title }}</a></li>
                        @endunless
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-lg-3">
            <audio preload></audio>
            <div id="dz-root"></div>
            <br/>
            <ol class="musicList">
                @foreach($tracks as $track)
                <li>
                    <a href="#" data-src="{{$track->track_url}}"> {{$track->track->title}}</a>
                    @if($user->id != Karma\Auth\OAuth::getUserId())
                    <a href="#" class="addTrack" data-id="{{$track->id}}">
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                    @endif
                </li>
                @endforeach
            </ol>
        </div>
    </div>
    
    <div class="col-md-6 center-block">
        <h2>Группы</h2>
        <hr>
    </div>
</div>
@stop