<h3><strong>{{ $track->track->artist->name }}</strong>&nbsp;-&nbsp;{{ $track->track->title }}&nbsp;
    <a href="#" class="addTrack" deezer="{{isset($deezer)}}"
       data-src="{{$track->track_url}}" data-cover="{{$track->track->albums->first()->artwork or ''}}">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
    <div class="raty-rated" data-rate="4"></div>
</h3>