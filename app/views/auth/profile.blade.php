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
        
        <div class="welcome">
            <h1>User profile(id = {{ $user->id }})</h1>
            <h1>
                <img src="{{ $user->photo }}" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6)">
            </h1>
        <h1>{{ $user->first_name .' '.$user->last_name }}</h1>
        <div>
            <a href="{{ URL::route('logoutAuth') }}" title="Log Out">
                <img src="{{ URL::asset('public/forward.png') }}">
            </a>    
        </div>
        </div>
    </body>
</html>
