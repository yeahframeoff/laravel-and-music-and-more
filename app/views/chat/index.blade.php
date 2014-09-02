@extends('layouts.main')

@section('scripts')
    @parent
    {{ HTML::script('public/js/getFriends.js') }}
@stop

@section('content')

<div class="tabbable tabs-left">
    <ul class="nav nav-tabs" id="users-container">
    </ul>
</div>

<script type="text/template" id="user-template">
    <li>
        <a href="{{action('Karma\Controllers\ChatController@chatWithUser', '')}}/<%= model.id %>" display="inline">
            <%= model.first_name %> <%= model.last_name %>
            <%= model.online %>
        </a>
    </li>
    <br/>
</script>
@stop