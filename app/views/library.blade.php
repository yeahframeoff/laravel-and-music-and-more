@extends('layouts.main')
@section('content')
<ul class="nav nav-pills">
    <li class="active"><a href="#all" data-toggle="pill">Все треки</a></li>
    <li class="active"><a href="#playlists" data-toggle="pill">Плейлисты</a></li>
</ul>


<div class="tab-content">
    <div class="tab-pane active" id="all">
        <div class="page-header">
            <h1>Все треки</h1>
        </div>
        
        
    </div>

    <div class="tab-pane" id="requests">
        <div class="page-header">
            <h1>Плейлисты</h1>
        </div>
    </div>
</div>
@stop