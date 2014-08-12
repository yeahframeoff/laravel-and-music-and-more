@extends('layouts.main')
@section('content')
<div id="logo" class="text-center">karma</div>

<div id="socials" class="text-center">
    <h2 class="text-center title">Импорт музыки</h2>
    <br>
    <br>
    <br>
    <br>
    
    <span class="social shadow">
        @if(isset($socials['fb']))
        	<a href="{{ URL::to('/import/fb') }}">{{ HTML::image('public/images/FB_logo_big.png', 'Facebook', array('title' => 'Импорт музыки из Facebook')) }}</a>
        @else
        	<a href="{{ URL::to('/connect/fb') }}">{{ HTML::image('public/images/FB_logo_big.png', 'Facebook', array('class' => 'inactive')) }}</a>
            <div class="connect">
                Подключить
            </div>
        @endif
    </span>
    
    <span class="social shadow">
        @if(isset($socials['vk']))
        	<a href="{{ URL::to('/import/vk') }}">{{ HTML::image('public/images/VK_logo_big.png', 'Facebook', array('title' => 'Импорт музыки из Vkontakte')) }}</a>
        @else
        	<a href="{{ URL::to('/connect/vk') }}">{{ HTML::image('public/images/VK_logo_big.png', 'Vkontakte', array('class' => 'inactive')) }}</a>
        	<div class="connect">
                Подключить
            </div>
        @endif
    </span>
    
    <span class="social shadow">
        @if(isset($socials['ok']))
        	<a href="{{ URL::to('/import/ok') }}">{{ HTML::image('public/images/OK_logo_big.png', 'Facebook', array('title' => 'Импорт музыки из Одноклассники')) }}</a>
        @else
        	<a href="{{ URL::to('/connect/ok') }}">{{ HTML::image('public/images/OK_logo_big.png', 'Одноклассники', array('class' => 'inactive')) }}</a>
            <div class="connect">
                Подключить
            </div>
        @endif
    </span>
</div>
@stop