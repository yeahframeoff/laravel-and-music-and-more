<!DOCTYPE html>
<html>
    <head>
        <title>Karma</title>
        <meta charset="UTF-8">
        {{ HTML::style('..\styles\fonts.css') }}
        {{ HTML::style('..\styles\main.css') }}
    </head>
    
    <body>
        <nav>
            <div class="nav-element">
                Правовые обязательства
            </div>
            
        	<div class="nav-element">
                О нас
            </div>
        </nav>
        
        {{ $content }}
        
        <div id="copy">
        	&copy; 2014 - {{ date("Y") }} Binary Studio Academy   
        </div>
    </body>
</html>