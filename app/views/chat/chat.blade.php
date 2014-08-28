@extends('layouts.main')

@section('scripts')
@parent
    {{ HTML::script('public/js/handlebars.runtime-v1.3.0.js') }}
    {{ HTML::script('public/js/underscore-min.js') }}
    {{ HTML::script('public/js/backbone-min.js') }}
    {{ HTML::script('public/js/chat.js') }}
@stop

@section('content')

{{
$path = $app['config']['session.files'];
//dd($app['files']);
$files = new \Illuminate\Session\FileSessionHandler($app['files'], $path);
//dd($files->read('1bd425b29ad260f7f98c2027798b997d16bd8e7c'));
}}

{{\Session::getName()}}
{{\Session::getId()}}
{{var_dump(\Session::all())}}
{{\Session::setId('1bd425b29ad260f7f98c2027798b997d16bd8e7c')}}
{{\Session::start()}}
{{var_dump(\Session::all())}}

<div id="messagesContainer">
    <did id="messages"></did>
    <br/>
    <div class="input-group">
        <input type="text" class="form-control"/>
        <span class="input-group-btn">
            <button class="btn btn-default send">Send</button>
        </span>
    </div>
</div>

<script type="text/x-handlebars" id="messageTemplate">
    @{{this.user_name}}:
    @{{this.message}}
    <br/>
</script>
@stop