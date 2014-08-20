@extends('layouts.main')
@section('content')
<div style="margin: auto 0;">
    <span class="glyphicon glyphicon-user"></span>&nbsp;
    <h1 style="display: inline;">{{ $user->first_name . ' ' . $user->last_name  }}</h1>
</div>

<hr>

<div class="row">
    <div class="col-md-6">
        <h2></h2>
    	{{ HTML::image($user->photo, $user->first_name . ' ' . $user->last_name, array('title' => $user->first_name . ' ' . $user->last_name, 'class' => 'img-thumbnail')) }}
    </div>
    
    <div class="col-md-6">
        <h2>Друзья</h2>
        <hr>
        
        @for ($i = 0; $i < count($user->friends()); $i++)
            @if($i % 3 == 0)
                <span class="terminator"></span>
            @endif

            <div class="tile-3 square">
                <a href="{{ URL::route('userprofile', array('user' => $user->friends()[$i]->id)) }}">
                   {{ HTML::image($user->friends()[$i]->photo, $user->friends()[$i]->first_name . ' ' . $user->friends()[$i]->last_name, array('title' => $user->friends()[$i]->first_name . ' ' . $user->friends()[$i]->last_name, 'class' => 'img-thumbnail')) }}
                </a>
            </div>
        @endfor
    </div>
</div>

<div class="row">
    <div class="col-md-6">
            <br>
    	@if($user->id != Session::get('user_id'))
            <div class="btn-group">
                @if(Karma\Entities\User::find(Session::get('user_id'))->isFriend($user->id))
                    <a class="btn" href="{{ URL::to('profile/addFriend/' . $user->id) }}">
                        <span class="glyphicon glyphicon-user"></span> Добавить в друзья 
                    </a>
                @else
                    <a class="btn" href="{{ URL::to('profile/deleteFriend/' . $user->id) }}">
                        <span class="glyphicon glyphicon-user"></span> Удалить из друзей
                    </a>
                @endif
            </div>                
        @else
             <div class="btn-group">
                 @foreach($user->socials() as $name => $main)
                     <a class="btn" href="">
                         {{ HTML::image('public/images/' . strtoupper($name) . '_logo_small.png') }}
                         
                         @if($name == 'vk')
                             Вконтакте @if($main)<span class="glyphicon glyphicon-ok"></span>@endif
                         @elseif($name == 'fb')
                             Facebook @if($main)<span class="glyphicon glyphicon-ok"></span>@endif
                         @elseif($name == 'ok')
                             Одноклассники @if($main)<span class="glyphicon glyphicon-ok"></span>@endif
                         @endif                             
                      </a>
                 @endforeach
            </div>        
        
            <div class="dropdown">
                <a href="#" class="dropdown-toggle btn" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-plus"></span>
                    <b class="caret"></b>
                </a>
                
                <ul class="dropdown-menu">
                    @if(!isset($user->socials()['vk']))<li><a href="connect/vk">Вконтакте</a></li>@endif
                    @if(!isset($user->socials()['fb']))<li><a href="connect/fb">Facebook</a></li>@endif
                    @if(!isset($user->socials()['ok']))<li><a href="connect/ok">Одноклассники</a></li>@endif
                </ul>
            </div> 
        @endif
    </div>
    
    <div class="col-md-6 center-block">
        <h2>Группы</h2>
        <hr>

    </div>
</div>
@stop