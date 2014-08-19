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
        
        @for ($i = 0; $i < count($friends); $i++)
            <div class="tile-3 square@if($i % 3 == 0) terminator@endif">
                <a href="{{ URL::route('userprofile', array('user' => $friends[$i]->id)) }}">
                   {{ HTML::image($friends[$i]->photo, $friends[$i]->first_name . ' ' . $friends[$i]->last_name, array('title' => $friends[$i]->first_name . ' ' . $friends[$i]->last_name, 'class' => 'img-thumbnail')) }}
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
                <a class="btn" href="{{ URL::to('profile/addFriend/' . $user->id) }}">
                    <span class="glyphicon glyphicon-user"></span> Добавить в друзья 
                </a>
            </div>                
        @else
             <div class="btn-group btn-group-justified">
                 @foreach($socials as $name => $main)
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
                 
                 <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                         <span class="glyphicon glyphicon-plus"></span>
                         <b class="caret"></b>
                     </a>

                     <ul class="dropdown-menu">
                         @foreach(array('vk' => 'Вконтакте', 'fb' => 'Facebook', 'ok' => 'Одноклассники') as $soc => $name)
                             @if(!isset($socials[$soc]))<li><a href="{{ URL::to('login/'.$soc) }}">$name</a></li>@endif
                         @endforeach
                     </ul>
                </li>
                 
                     
             </div>        
        @endif
    </div>
    
    <div class="col-md-6 center-block">
        <h2>Группы</h2>
        <hr>

    </div>
</div>
@stop