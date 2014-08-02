<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Karma</title>
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:700);

		body {
			margin:0;
			font-family:'Lato', Segoe UI Semibold, sans-serif;
			text-align:center;
			color: #999;
		}

		.welcome {
			width: 800px;
			height: 500px;
			position: absolute;
			left: 50%;
			top: 50%;
			margin-left: -400px;
			margin-top: -250px;
		}

		a, a:visited {
			text-decoration:none;
		}

		h1 {
			font-size: 32px;
			margin: 16px 0 0 0;
		}
	</style>
</head>
<body>
    {{-- $user_data --}}
    
    <div class="welcome">
        <h1>You've been successfully authorized via VK!</h1>
	    <h1>
            <a href="https://vk.com/id{{ $user_data['id'] or $user_data['uid']}}" title="Watch on VK.com" target="blank">
                <img src="{{ $user_data['photo_200'] }}" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6)">
            </a>    
        </h1>
        <h1>User #{{ $user_data['id'] or $user_data['uid']}}</h1>
        <h1>{{ $user_data['first_name'] .' '.$user_data['last_name'] }}</h1>
        <h1>{{ $user_data['city']['title'] or ''}}, {{ $user_data['country']['title'] or ''}}</h1>
        <div>
            <a href="{{ URL::route('vkLogOut') }}" title="Log Out">
                <img src="{{ URL::asset('public/forward.png') }}">
            </a>    
        </div>
	</div>
</body>
</html>
