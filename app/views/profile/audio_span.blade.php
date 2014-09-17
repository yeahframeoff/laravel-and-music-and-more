<div class="col-lg-3">
    <audio preload></audio>
    <div id="dz-root"></div>
    <br/>
    <ol class="musicList">
        <?php
        $tracks = $user->tracks;
        $tracks = ($tracks->count() > 6 ? $tracks->random(6) : $tracks);
        ?>
        @foreach($tracks as $track)
        <li>
            <a href="#" data-src="{{$track->track_url}}"> {{$track->track->title}}</a>
            @if($user->id != KAuth::getUserId())
            <a href="#" class="addTrack" data-id="{{$track->id}}">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
            @endif
        </li>
        @endforeach
    </ol>
</div>