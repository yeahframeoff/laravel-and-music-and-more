@extends('layouts.main')
@section('content')
<div id="logo" class="text-center">karma</div>

<div id="socials" class="text-center">
    <h2 class="text-center title">Импорт музыки</h2>
    
    <span class="social shadow">
        @if(isset($socials['fb']))
        	<a href="{{ URL::to('/import/fb') }}">{{ HTML::image('public/images/FB_logo_big.png', 'Facebook', array('title' => 'Импорт музыки из Facebook')) }}</a>
        @else
        	{{ HTML::image('public/images/FB_logo_big.png', 'Facebook', array('title' => 'Импорт музыки из Facebook', 'class' => 'inactive')) }}
        @endif
    </span>
    
    <span class="social shadow">
        @if(isset($socials['vk']))
        	<a href="{{ URL::to('/import/vk') }}">{{ HTML::image('public/images/VK_logo_big.png', 'Facebook', array('title' => 'Импорт музыки из Vkontakte')) }}</a>
        @else
        	{{ HTML::image('public/images/VK_logo_big.png', 'Vkontakte', array('title' => 'Импорт музыки из Vkontakte', 'class' => 'inactive')) }}
        @endif
    </span>
    
    <span class="social shadow">
        @if(isset($socials['ok']))
        	<a href="{{ URL::to('/import/ok') }}">{{ HTML::image('public/images/OK_logo_big.png', 'Facebook', array('title' => 'Импорт музыки из Одноклассники')) }}</a>
        @else
        	{{ HTML::image('public/images/OK_logo_big.png', 'Одноклассники', array('title' => 'Импорт музыки из Одноклассники', 'class' => 'inactive')) }}
        @endif
    </span>
</div>
@stop