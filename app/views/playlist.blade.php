<div class="panel panel-default">
    <div class="panel-heading">
        <a data-toggle="collapse" href="#playlist{{$list->id}}">{{ $list->name }}</a>
    </div>
    <div id="playlist{{$list->id}}" class="panel-collapse collapse">
        <ul class="list-group">
            @foreach ($playlist->tracks as $track)
                <li class="list-group-item"">@include ('track_tile', ['track' => $track->track])</li>
            @endforeach
        </ul>
    </div>
</div>