@extends('layouts.main')
@section('content')
<div class="col-lg-8">
    @if ($post->id !== null)
    {{ Form::open(['route' => ['feed.update', $post->id], 'method' => 'PUT']) }}
    @else
    {{ Form::open(['route' => 'feed.store' ]) }}
    @endif
    <div class="row">
    <label class="h2" for="post-text">
        New post
    </label>
    <textarea id="post-text" name="text" class="form-control" rows="3">{{$post->text}}</textarea>
    </div>
    <hr>
    <div class="row">
        <label class="col-lg-12">
            Tracks
            <select name="tracks[]" multiple id="tracks" class="form-control">
                @foreach ($post->tracks as $track)
                    <option selected value="{{$track->id}}">{{$track->artist->name . ' ' . $track->title}}</option>
                @endforeach
                @foreach ($tracks as $track)
                    <option value="{{$track->id}}">{{$track->artist->name . ' ' . $track->title}}</option>
                @endforeach
            </select>
        </label>
        <label class="col-lg-12">
            Playlists
            <select name="playlists[]" multiple id="playlists" class="form-control">
                @foreach ($post->playlists as $list)
                    <option selected value="{{$list->id}}">{{$list->name}}</option>
                @endforeach
                @foreach ($playlists as $list)
                    <option value="{{$list->id}}">{{$list->name}}</option>
                @endforeach
            </select>
        </label>
        @if ($post->id === null)
        <label class="col-lg-12">
            To whom:
            <select id="receiver" name="receiver" class="form-control">
                <option value="0">Public</option>
                @foreach (KAuth::user()->friends() as $fr)
                    <option value="{{$fr->id}}">{{$fr}}</option>
                @endforeach
            </select>
        </label>
        @endif
    </div>
    <hr>
    <input type="submit" value="Post" class="btn btn-default btn-block"/>
    {{ Form::close() }}
</div>
@stop
@section('scripts')
@parent
<script>
    $(function(){
        var selectizeParams = {
            sortField: 'text'
        };
        $('#receiver').selectize(selectizeParams);
        $('#tracks').selectize(selectizeParams);
        $('#playlists').selectize(selectizeParams);
    });
</script>
@stop
