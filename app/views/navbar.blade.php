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
                	<li class="dropdown @if (Request::is('search/*')) active @endif">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Поиск
                            <b class="caret"></b>
                        </a>

                        <ul class="dropdown-menu">
                            <li @if(Request::is('/search/music'))class="active"@endif><a href="{{ URL::to('search/music') }}">Музыка</a></li>
                            <li @if(Request::is('/search/people'))class="active"@endif><a href="{{ URL::to('search/people') }}">Люди</a></li>
                            <li @if(Request::is('/search/groups'))class="active"@endif><a href="{{ URL::to('search/groups') }}">Группы</a>
                        </ul>
                	</li>

                    <li class="dropdown">
                        <a id="notify-check" href="#" data-href="{{ URL::route('notify.check') }}"
                            data-toggle="dropdown" data-placement="bottom" data-trigger="manual">
                            <span class="glyphicon glyphicon-globe"></span><span id="badge"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a>Action</a></li>
                            <li><a>Another action</a></li>
                            <li><a>Something else here</a></li>
                            <li class="divider"></li>
                            <li><a>Separated link</a></li>
                        </ul>
                    </li>

                    <li @if(Request::is('/friends*')) class="active" @endif >
                        @if ($count = \KAuth::user()->friendshipRequestsCount() > 0 )
                            <div class="btn-group btn-group-sm" style="margin: 10% auto">
                                <a class="btn btn-primary" href="{{ URL::route('friends.my') }}"><strong>Друзья</strong></a>
                                <a class="btn btn-default" href="{{ URL::route('friends.my') }}?p=requests"><strong>+{{$count}}</strong></a>
                            </div>
                        @else
                            <a href="{{ URL::route('friends.my') }}">Друзья</a>
                        @endif

                    </li>

                	<li @if(Request::is('/user/groups'))class="active"@endif><a href="{{ URL::to('groups') }}">Группы</a></li>
                	<li @if(Request::is('/user/messages'))class="active"@endif><a href="{{ URL::to('messages') }}">Диалоги</a></li>
                	<li @if(Request::is('/user/library'))class="active"@endif><a href="{{ URL::to('library') }}">Библиотека</a></li>
                	<li @if(Request::is('/user/profile'))class="active"@endif><a href="{{ URL::to('profile') }}">Профиль</a></li>
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