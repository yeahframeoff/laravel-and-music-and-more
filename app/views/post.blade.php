<h3>User <a href="{{$post->author->profileUrl}}">{{$post->author}}</a> at {{$post->created_at}}:<br></h3>
<h4>{{$post->text}}</h4>
@foreach($post->tracks as $track)
    <a href="#">@include('track_tile', ['track' => $track]) </a>
    <hr>
@endforeach
@foreach($post->playlists as $list)
    <h3>{{ $list->name }}</h3>
     @include('playlist', ['playlist' => $list])
    <hr>
@endforeach