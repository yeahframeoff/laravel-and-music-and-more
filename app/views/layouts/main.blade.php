<!DOCTYPE html>
<html>
	<head>
		<title>Karma</title>
        <meta charset="UTF-8">
        <meta lang="ru">
        @section('stylesheets')
            {{ HTML::style('public/css/own.css') }}
            {{ HTML::style('public/css/bootstrap.css') }}
        @show
	</head>
	
	<body>
		@include('navbar')		
		
        <div class="container">
            @yield('content')
        </div>

        @section('scripts')
        {{ HTML::script('http://code.jquery.com/jquery-2.1.1.js') }}
        {{ HTML::script('public/js/bootstrap.js') }}
        {{ HTML::script('public/audiojs/audio.min.js') }}
        {{ HTML::script('public/js/audioController.js') }}
        {{ HTML::script('public/js/importController.js') }}
        {{ HTML::script('http://cdn-files.deezer.com/js/min/dz.js') }}
        @show

	</body>
</html>