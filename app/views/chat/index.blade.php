@extends('layouts.main')
@section('content')

<div class="tabbable tabs-left">
    <ul class="nav nav-tabs">
        @foreach($friends as $friend)
        <li>
            <a href="{{action('Karma\Controllers\ChatController@chatWithUser', $friend->id)}}" display="inline">
                {{$friend->first_name . ' ' . $friend->last_name }}
            </a>
        </li>
        <br>
        @endforeach
    </ul>
</div>

<script type="text/x-handlebars">
    @{{outlet}}
</script>
<script type="text/x-handlebars-template" id="messagesTemplate">
    @{{#each []}}
        @{{this.user_name}}:
        @{{this.message}}
        <br/>
    @{{/each}}
    <div class="input-group">
        <input type="text" class="form-control"/>
        <span class="input-group-btn">
            <button class="btn btn-default send">Send</button>
        </span>
    </div>
</script>
@stop