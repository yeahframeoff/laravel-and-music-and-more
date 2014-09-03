@extends('layouts.main')

@section('content')
    @foreach ($posts as $post)
        @include ('post', ['post' => $post])
        <hr>
    @endforeach
@stop
