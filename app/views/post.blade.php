<div class="panel panel-default">
    <div class="panel-heading">
        <h4 >User <a href="{{$post->author->profileUrl}}">{{$post->author}}</a>
            at {{$post->created_at}}:
        </h4>
        @if($post->author_id == KAuth::getUserId())
        <div class="btn-group pull-right">
            <a href="{{URL::route('feed.edit', ['feed' => $post->id])}}"
               data-method="get"
               class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit
            </a>
            <a href="{{URL::route('feed.destroy', ['feed' => $post->id])}}"
               data-method="delete"
               class="btn btn-danger btn-sm please-work-http-delete-button">
                <span class="glyphicon glyphicon-remove"></span>&nbsp;Delete
            </a>
        </div>
        @endif
    </div>
    <div class="panel-body">
        <h4>{{$post->text}}</h4>
        <ol class="musicList">
            @foreach($post->tracks as $track)
                <li class="musicPlayer li">
                   @include('track_tile', ['track' => $track])
                </li>
            @endforeach
            @foreach($post->playlists as $list)
                 @include('playlist', ['playlist' => $list])
            @endforeach
        </ol>
    </div>
</div>
