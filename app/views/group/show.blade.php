@extends('layouts.main')

@section('scripts')
@parent
    <script type="text/javascript">
        groupId = {{$group->id}};
    </script>
    {{ HTML::script('public/js/groups.js') }}
@stop

@section('content')

<h1>{{$group->name}}</h1>
@if($group->founder_id == KAuth::getUserId())
    <button type="button" class="btn btn-default broadcast-btn" data-active={{$group->active}}>
        @if($group->active)
            Stop broadcast
        @else
            Start broadcast
        @endif
    </button>
@else
    @if($group->active)
        <button type="button" class="btn btn-default subscribe-btn" data-active={{$group->isListener(KAuth::getUserId())}}>
            @if($group->isListener(KAuth::getUserId()))
                Unsubscribe
            @else
                Subscribe
            @endif
        </button>
    @endif
@endif

@foreach($group->activeUsers as $activeUser)
    {{$activeUser->first_name . ' ' . $activeUser->last_name}}
    <br/>
@endforeach

@if(count($group->tracks) > 0)
    @include ('layouts.player', ['playClass' => 'play-broadcast'])
@endif


<br/>
<ol class="musicList">
    @foreach($group->tracks as $track)
        <li class="musicPlayer li">
            <a href="#" data-src="{{$track->track_url}}" data-cover="{{$track->track->albums->first()->artwork or ''}}"> {{$track->track->title}}</a>
        </li>
    @endforeach
</ol>

@stop
