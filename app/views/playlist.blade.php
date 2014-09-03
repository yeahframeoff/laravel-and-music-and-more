<ul class="list-group">
    @foreach ($playlist->tracks as $track)
        <li class="list-group-item">@include ('track_tile', ['track' => $track->track])</li>
    @endforeach
</ul>
