@extends('layouts.main')
@section('content')


{{ Form::open(array('action' => array('Karma\Controllers\ImportController@importSelect', $provider))) }}
@if ($provider == 'vk')
    @forelse ($tracks as $track)
        {{$track['artist']}} - {{$track['title']}}
        <input type="checkbox" name="{{$track['title']}}" value="{{$track['artist']}}|{{$track['url']}}|{{$track['aid']}}">
        <br/>
    @empty
        <h2>Нет новой музыки для импорта</h2>
    @endforelse
@endif

@if ($provider == 'fb')
<div class="tabbable tabs-left">
    <ul class="nav nav-tabs">
        @foreach($tracks as $artist => $albums)
            <li>
                <a href="#{{$artist}}" data-toggle="tab" display="inline">
                    {{$artist}}
                </a>
                <input type="checkbox" class="artist {{$artist}}" name="artist{{$artist}}">
            </li>
           <br>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach($tracks as $artist => $albums)
            <div class="tab-pane" id="{{$artist}}">
                <div class="tabbable tabs-left">
                    <ul class="nav nav-tabs">
                        @forelse($albums as $album => $tracks)
                            <li>
                                <a href="#{{$album}}" data-toggle="tab">
                                    {{$album}}
                                </a>
                                <input type="checkbox" class="album {{$album}}" name="album{{$album}}">
                            </li>
                        @empty
                            <h2>Нет новой музыки для импорта</h2>
                        @endforelse
                    </ul>
                    <div class="tab-content">
                        @foreach($albums as $album => $tracks)
                            <div class="tab-pane" id="{{$album}}">
                                @foreach($tracks as $track)
                                    {{$track->title}}
                                    <input type="checkbox" class="track {{$track->title}}" name="{{$track->title}}" value="{{$artist}}|{{$track->id}}">
                                    <br/>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif
{{ Form::submit('Import', array('class' => 'btn btn-primary')) }}
{{ Form::close() }}

@stop
