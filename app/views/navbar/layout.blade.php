<nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::to('/') }}">Karma</a>
        </div>

        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <li @if(Request::is('/'))class="active"@endif><a href="{{ URL::to('/') }}">Главная</a></li>
                <li @if(Request::is('rights'))class="active"@endif><a href="{{ URL::to('rights') }}">Правообладателям</a></li>
                <li @if(Request::is('about'))class="active"@endif><a href="{{ URL::to('about') }}">О нас</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if(Karma\Controllers\AuthController::logged())
                    @include('navbar.logged_only')
                @else
                    @include('navbar.guest_only')
                @endif
            </ul>
        </div>
    </div>
</nav>