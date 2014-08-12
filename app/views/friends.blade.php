@extends('layouts.main')
@section('content')
@foreach($friends as $friend)
<h1>{{ $friend->first_name }}</h1>
<h1>{{ $friend->last_name }}</h1>
{{ HTML::image($friend->photo, $friend->first_name . ' ' . $friend->last_name) }}
@endforeach
@stop