@extends('layouts.main')

@section('scripts')
@parent
    {{ HTML::script('public/js/chat.js') }}
@stop

@section('content')

<div class="row">
    <div class="col-md-2">
        <div id="users-main-container">
            <div class="tabbable tabs-left">
                <ul class="nav nav-tabs" id="users-container">
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div id="messages-container">
            <div id="active-user"></div>
            <div id="messages"></div>
            <br/>
            <div class="input-group">
                <input type="text" class="form-control"/>
        <span class="input-group-btn">
            <button class="btn btn-default send">Send</button>
        </span>
            </div>
        </div>
    </div>

</div>

<script type="text/template" id="message-template">
    <% if(model.from_user_id == thisUser.id){ %>
        <p class="bg-success"> <%= author.first_name %>: <%= model.message%> </p>
    <%} else {%>
        <p class="bg-warning"> <%= author.first_name %>: <%= model.message%> </p>
    <% } %>
</script>

<script type="text/template" id="user-template">
    <li>
            <%= model.first_name %> <%= model.last_name %>
            <% (model.isOnline) ? print('online') : print('offline') %>
    </li>
    <br/>
</script>
@stop