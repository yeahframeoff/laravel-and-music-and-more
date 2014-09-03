@extends('layouts.main')
@section('content')
<script>
    function move(selectorId, listId)
    {
        var selector = document.getElementById(selectorId);
        var item = selector.options[selector.selectedIndex];
        if (item !== null)
        {
            document.getElementById(listId).add(item);
            //selector.remove(selector.selectedIndex);
        }
    }

    function retrieveItems(id)
    {
        var sel = document.getElementById(id);
        var arr = [];
        [].forEach.call(sel.options, function(elm){ elm.selected = false; arr.push(elm.value); });
        sel.options[0].selected = true;
        sel.options[0].value = arr.join(' ');
    }
</script>
<div class="col-lg-6">
    {{ Form::open(['route' => 'feed.store']) }}
    <div class="row">
        <textarea name="text" class="form-control" rows="3"></textarea>
    </div>
    <div class="row">
        <label class="col-lg-6">
            Tracks
            <select name="tracks" id="tracks" multiple class="form-control"></select>
            <select id="available_tracks" class="form-control"
                onchange="move('available_tracks', 'tracks')">
                <option selected value=""></option>
                @foreach ($tracks as $track)
                    <option value="{{$track->id}}">{{$track->artist->name . ' ' . $track->title}}</option>
                @endforeach
            </select>

            <input type="button" class="btn btn-default btn-block" value="Delete"
                    onclick="move('tracks', 'available_tracks')"/>
        </label>
        <label class="col-lg-6">
            Playlists
            <select name="playlists" id="playlists"  multiple class="form-control"></select>

            <select id="available_playlists" class="form-control"
                onchange="move('available_playlists', 'playlists')">
                <option selected value=""></option>
                @foreach ($playlists as $list)
                    <option value="{{$list->id}}">{{$list->name}}</option>
                @endforeach
            </select>

            <input type="button" class="btn btn-default btn-block" value="Delete"
                    onclick="move('playlists', 'available_playlists')"/>
        </label>

        <input type="submit" value="Post" class="btn btn-default btn-block"
            onclick="retrieveItems('tracks'); retrieveItems('playlists');"/>
    </div>

    {{ Form::close() }}
</div>
@stop
