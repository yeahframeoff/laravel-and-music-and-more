@extends('layouts.main')

@section('scripts')
@parent
    {{ HTML::script('public/js/chat.js') }}
@stop

@section('content')

<div id="users-main-container">
    <div class="tabbable tabs-left">
        <ul class="nav nav-tabs" id="users-container">
        </ul>
    </div>
</div>

<div id="messages-container">
    <did id="messages"></did>
    <br/>
    <div class="input-group">
        <input type="text" class="form-control"/>
        <span class="input-group-btn">
            <button class="btn btn-default send">Send</button>
        </span>
    </div>
</div>

<script type="text/template" id="message-template">
    <%= author.first_name %>:
    <%= model.message %> <%= model.id %>
    <br/>
</script>

<script type="text/template" id="user-template">
    <li>
            <%= model.first_name %> <%= model.last_name %>
            <%= model.isOnline %>
    </li>
    <br/>
</script>
@stop