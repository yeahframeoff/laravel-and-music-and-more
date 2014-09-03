<div class="panel panel-default">
    <div class="panel-heading">
        <h4 >User <a href="{{$post->author->profileUrl}}">{{$post->author}}</a>
            at {{$post->created_at}}:
        </h4>
        @if($post->author_id == KAuth::getUserId())
        <div class="btn-group pull-right">
            {{--
            {{ Form::open(['route' => ['feed.edit', $post->id]]) }}
            {{ Form::button('<span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit',
            ['class' => 'btn btn-default btn-sm'])}}
            {{ Form::close() }}
            {{ Form::open(['route' => ['feed.destroy', $post->id]]) }}
            {{ Form::button('<span class="glyphicon glyphicon-remove"></span>&nbsp;Delete',
            ['class' => 'btn btn-danger btn-sm'])}}
            {{ Form::close() }}
            --}}
            <a href="{{URL::route('feed.edit', ['feed' => $post->id])}}" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a>
            <a href="{{URL::route('feed.destroy', ['feed' => $post->id])}}" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span>&nbsp;Delete</a>

        </div>
        @endif
    </div>
    <div class="panel-body">
        <h4>{{$post->text}}</h4>
        @foreach($post->tracks as $track)
            <a href="#">@include('track_tile', ['track' => $track]) </a>
        @endforeach
        @foreach($post->playlists as $list)
             @include('playlist', ['playlist' => $list])

        @endforeach
    </div>
</div>
