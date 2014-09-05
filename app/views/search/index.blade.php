@extends('layouts.main')

@section('content')
    <form class="input-group" action="{{ \URL::route('search.deezer') }}">
        <input type="text" class="form-control" name="q"/>
        <span class="input-group-btn">
            <input class="btn btn-primary" type="submit" value="Search">
        </span>
    </form><!-- /input-group -->
@stop