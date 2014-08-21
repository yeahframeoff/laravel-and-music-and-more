@extends('layouts.main')
@section('content')


{{ Form::open(array('action' => array('Karma\Controllers\ImportController@importSelect', $provider))) }}
@if ($provider == 'vk')
    @foreach ($tracks as $track)
        {{$track['artist']}} - {{$track['title']}}
        <input type="checkbox" name="{{$track['title']}}" value="{{$track['artist']}}|{{$track['url']}}|{{$track['aid']}}">
        <br/>
    @endforeach
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
                        @foreach($albums as $album => $tracks)
                            <li>
                                <a href="#{{$album}}" data-toggle="tab">
                                    {{$album}}
                                </a>
                                <input type="checkbox" class="album {{$album}}" name="album{{$album}}">
                            </li>
                        @endforeach
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


<!-- tabs left -->
<!--
<div class="tabbable tabs-left">
    <ul class="nav nav-tabs">
        <li><a href="#a" data-toggle="tab">One</a></li>
        <li class="active"><a href="#b" data-toggle="tab">Two</a></li>
        <li><a href="#c" data-toggle="tab">Twee</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="a">
            <div class="tabbable tabs-left">
                <ul class="nav nav-tabs">
                    <li><a href="#aa" data-toggle="tab">One</a></li>
                    <li class="active"><a href="#bb" data-toggle="tab">Two</a></li>
                    <li><a href="#cc" data-toggle="tab">Twee</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="aa">Lorem ipsum dolor sit amet, charetra varius quam sit amet vulputate.
                        Quisque mauris augue, molestie tincidunt condimentum vitae, gravida a libero.</div>
                    <div class="tab-pane" id="bb">Secondo sed ac orci quis tortor imperdiet venenatis. Duis elementum auctor accumsan.
                        Aliquam in felis sit amet augue.</div>
                    <div class="tab-pane" id="cc">Thirdamuno, ipsum dolor sit amet, consectetur adipiscing elit. Duis pharetra varius quam sit amet vulputate.
                        Quisque mauris augue, molestie tincidunt condimentum vitae. </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="b">Secondo sed ac orci quis tortor imperdiet venenatis. Duis elementum auctor accumsan.
            Aliquam in felis sit amet augue.</div>
        <div class="tab-pane" id="c">Thirdamuno, ipsum dolor sit amet, consectetur adipiscing elit. Duis pharetra varius quam sit amet vulputate.
            Quisque mauris augue, molestie tincidunt condimentum vitae. </div>
    </div>
</div>
-->
<!-- /tabs -->
@stop