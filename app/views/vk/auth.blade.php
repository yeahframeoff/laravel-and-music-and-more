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
			width: 300px;
			height: 200px;
			position: absolute;
			left: 50%;
			top: 50%;
			margin-left: -150px;
			margin-top: -100px;
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
	<div class="welcome">
		<a href="{{ $vk_url }}" title="VK.com"><img src="{{ URL::asset('public/VK_logo.png') }}"></a>
		<h1>Sign in via VK.com</h1>
	</div>
</body>
</html>
