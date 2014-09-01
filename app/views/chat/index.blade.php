@extends('layouts.main')

@section('scripts')
    @parent
    {{ HTML::script('public/js/handlebars.runtime-v1.3.0.js') }}
    {{ HTML::script('public/js/getFriends.js') }}
@stop

@section('content')

<div class="tabbable tabs-left">
    <ul class="nav nav-tabs" id="usersContainer">
    </ul>
</div>

<script type="text/x-handlebars">
    @{{outlet}}
</script>

<script type="text/x-handlebars-template" id="userTemplate">
    <li>
        <a href="{{action('Karma\Controllers\ChatController@chatWithUser', '')}}/@{{this.id}}" display="inline">
            @{{this.first_name}} @{{this.last_name}}
            @{{this.online}}
        </a>
    </li>
    <br/>
</script>
@stop