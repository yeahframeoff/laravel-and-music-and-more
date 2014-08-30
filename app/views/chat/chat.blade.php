@extends('layouts.main')

@section('scripts')
@parent
    {{ HTML::script('public/js/handlebars.runtime-v1.3.0.js') }}
    <script type="text/javascript">
        var thisUser = {
            name: '{{Karma\Auth\OAuth::getUser()->first_name}}',
            user_id: {{Karma\Auth\OAuth::getUserId()}}
        };
        var recieverUser = {
            name: '{{$user->first_name}}',
            user_id: {{$user->id}}
        };
    </script>
    {{ HTML::script('public/js/chat.js') }}
@stop

@section('content')

<div id="messagesContainer">
    <did id="messages"></did>
    <br/>
    <div class="input-group">
        <input type="text" class="form-control"/>
        <span class="input-group-btn">
            <button class="btn btn-default send" user-name="{{$user->first_name}}" data-to="{{$user->id}}">Send</button>
        </span>
    </div>
</div>

<script type="text/x-handlebars" id="messageTemplate">
    @{{this.user_name}}:
    @{{this.message}}
    <br/>
</script>
@stop