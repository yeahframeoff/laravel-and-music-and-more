@extends('layouts.main')

@section('content')
    @forelse ($posts as $post)
        @include ('post', ['post' => $post])
        <hr>
    @empty
        <h2>No posts yet</h2>
        <a class="btn btn-primary" href="{{ URL::route('feed.create') }}"><strong>Create new</strong></a>
    @endforelse
@stop
