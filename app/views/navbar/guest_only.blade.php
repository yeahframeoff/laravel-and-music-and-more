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
