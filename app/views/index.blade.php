@extends('layouts.main')
@section('content')
<div id="logo" class="text-center">karma</div>

<div id="socials" class="text-center">
    <span class="social shadow">
        <a href="{{ URL::to($links['FB']) }}">{{ HTML::image('public/images/FB_logo_big.png', 'Facebook', array('title' => 'Войти через Facebook')) }}</a>
    </span>
    
    <span class="social shadow">
        <a href="{{ URL::to($links['VK']) }}">{{ HTML::image('public/images/VK_logo_big.png', 'Vkontakte', array('title' => 'Войти через Vkontakte')) }}</a>
    </span>
    
    <span class="social shadow">
        <a href="{{ URL::to($links['OK']) }}">{{ HTML::image('public/images/OK_logo_big.png', 'Одноклассники', array('title' => 'Войти через Одноклассники')) }}</a>
    </span>
</div>

<div id="about-brief" class="text-center">
    <p>
        Karma - простое и удобное средство для управления персональной фонотекой. 
Вы можете добавить сюда любое количество аудиозаписей из любой предложенной нами соцсети - Вконтакте, Facebook или Одноклассники. 
Вам предоставлены широкие возможности - от создания плейлистов, поиска похожей музыки и информации об артистах до возможности поделиться 
любимыми композициями с друзьями, которые также имеют аккаунт Karma. Ваши плейлисты автоматически синхронизируются с вашими плейлистами в 
соцсетях, так что не нужно об этом беспокоится! Хотите вещать - пожалуйста. Karma предоставляет возможность транслировать аудио в рамках сети 
вашим друзьям, так что они будут слышать то, что будете ставить Вы!
    </p>
</div>
@stop