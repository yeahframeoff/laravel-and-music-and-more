<!DOCTYPE html>
<html>
    <head>
        <title>Karma</title>
        <meta charset="UTF-8">
        <meta lang="ru">
        @section('stylesheets')
            {{ HTML::style('public/css/player.css') }}
            {{ HTML::style('public/css/own.css') }}
            {{ HTML::style('public/css/bootstrap.css') }}
            {{ HTML::style('public/css/bootstrap-theme.css') }}
            {{ HTML::style('public/css/jquery.raty.css') }}
            {{ HTML::style('public/css/selectize.css') }}
            {{ HTML::style('public/css/selectize.default.css') }}
            {{ HTML::style('public/css/selectize.bootstrap3.css') }}
        @show


	</head>

	<body>
		@include('navbar.layout')

        <div class="container" id="content">
            @yield('content')
        </div>

        @section('scripts')
        {{ HTML::script('http://code.jquery.com/jquery-2.1.1.js') }}
        {{-- HTML::script('public/js/libs/jquery.js') --}}
        {{ HTML::script('public/js/libs/bootstrap.min.js') }}
        {{ HTML::script('public/js/libs/dz.js') }}
        {{ HTML::script('public/js/audio5.js') }}
        {{ HTML::script('public/js/libs/underscore-min.js') }}
        {{ HTML::script('public/js/libs/backbone-min.js') }}
        {{ HTML::script('public/js/libs/selectize.min.js') }}
        {{ HTML::script('public/js/libs/jquery.raty.js') }}
        {{ HTML::script('public/js/libs/sprintf.min.js') }}
        {{ HTML::script('public/audiojs/audio.min.js') }}
        {{ HTML::script('public/js/friends.js') }}
        {{ HTML::script('public/js/importController.js') }}
        {{ HTML::script('public/audiojs/howler.js') }}
        {{ HTML::script('public/js/friends.js') }}
        {{ HTML::script('public/js/notification.js') }}
        {{ HTML::script('public/js/player.js') }}
        {{ HTML::script('public/js/httpdelete.js') }}
        {{ HTML::script('public/js/socket.js') }}
        {{ HTML::script('public/js/audioController.js') }}
        {{ HTML::script('public/js/rating.js') }}
        {{ HTML::script('public/js/main.js') }}
        @show

	</body>
</html>
