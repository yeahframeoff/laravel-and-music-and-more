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
        
        @section('scripts')
        	{{ HTML::script('http://code.jquery.com/jquery-2.1.1.js') }}
        	{{ HTML::script('public/js/bootstrap.js') }}
        @show
	</head>
	
	<body>
		@include('navbar')		
		
        <div class="container" id="content" >
            @yield('content')
        </div>
	</body>
</html>