<!DOCTYPE html>
<html>
	<head>
		<title>Karma</title>
        <meta charset="UTF-8">
        <meta lang="ru">
        @section('stylesheets')
            {{ HTML::style('public/css/own.css') }}
            {{ HTML::style('public/css/bootstrap.css') }}
            {{ HTML::style('public/css/bootstrap-theme.css') }}
        @show
	</head>
	
	<body>
		@include('navbar')		
		
        <div class="container" id="content">
            @yield('content')
        </div>
        @section('scripts')
        {{ HTML::script('http://code.jquery.com/jquery-2.1.1.js') }}
        {{ HTML::script('public/js/bootstrap.js') }}
        {{ HTML::script('public/audiojs/audio.min.js') }}
        {{ HTML::script('http://cdn-files.deezer.com/js/min/dz.js') }}
        {{ HTML::script('public/js/friends.js') }}
        {{ HTML::script('public/js/importController.js') }}
        {{ HTML::script('public/audiojs/howler.js') }}
        {{ HTML::script('public/js/audio5.js') }}
        {{ HTML::script('public/js/friends.js') }}
        {{ HTML::script('public/js/notification.js') }}
        {{ HTML::script('public/js/player.js') }}
        {{ HTML::script('public/js/main.js') }}
        {{ HTML::script('public/js/underscore-min.js') }}
        {{ HTML::script('public/js/backbone-min.js') }}
        {{ HTML::script('public/js/socket.js') }}
        @show
	</body>
</html>