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
                    <li><a href="{{ URL::route('feed.create') }}" class="glyphicon glyphicon-pencil"></a></li>
                    <li @if(Request::is('/feed')) class="active" @endif><a href="{{ URL::to('feed') }}">Лента</a></li>
                	<li class="dropdown @if (Request::is('search/*')) active @endif">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Поиск
                            <b class="caret"></b>
                        </a>

                        <ul class="dropdown-menu">
                            <li @if(Request::is('/search'))class="active"@endif><a href="{{ URL::to('search') }}">Люди/Музыка</a></li>
                            <li @if(Request::is('/search/groups'))class="active"@endif><a href="{{ URL::to('search/deezer') }}">Deezer</a>
                        </ul>
                	</li>

                    <li class="dropdown">
                        <a id="notify-check" href="#" data-href="{{ URL::route('notify.check') }}"
                            data-toggle="dropdown" data-placement="bottom" data-trigger="manual">
                            <span class="glyphicon glyphicon-globe"></span><span id="badge"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a>Нет непрочитанных уведомлений</a></li>
                        </ul>
                    </li>

                    <li @if(Request::is('/friends*')) class="active" @endif >
                        @if ($count = \KAuth::user()->friendshipz()->requests()->count() > 0)
                            <div class="btn-group btn-group-sm" style="margin: 10% auto">
                                <a class="btn btn-primary" href="{{ URL::route('friends.my') }}"><strong>Друзья</strong></a>
                                <a class="btn btn-default" href="{{ URL::route('friends.my') }}?p=requests"><strong>+{{$count}}</strong></a>
                            </div>
                        @else
                            <a href="{{ URL::route('friends.my') }}">Друзья</a>
                        @endif

                    </li>

                	<li @if(Request::is('/groups'))class="active"@endif><a href="{{ URL::to('groups') }}">Группы</a></li>
                	<li @if(Request::is('/messages'))class="active"@endif><a href="{{ URL::to('messages') }}">Диалоги</a></li>
                	<li @if(Request::is('/library'))class="active"@endif><a href="{{ URL::to('library') }}">Библиотека</a></li>
                	<li @if(Request::is('/profile'))class="active"@endif><a href="{{ URL::to('profile') }}">Профиль</a></li>
                    <li><a href="{{ URL::to('/logout') }}">Выйти</a></li>
                @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Войти
                        <b class="caret"></b>
                    </a>

                    <ul class="dropdown-menu">
                        <li id="fb-li"><a href="{{ URL::to('/login/fb') }}">Facebook</a></li>
                        <li id="vk-li"><a href="{{ URL::to('/login/vk') }}">Vkontakte</a></li>
                        <li id="ok-li"><a href="{{ URL::to('/login/ok')}}">Одноклассники</a></li>
                    </ul>

                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>