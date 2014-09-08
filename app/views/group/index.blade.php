@extends('layouts.main')

@section('scripts')
@parent
    {{ HTML::script('public/js/autobahn.min.js') }}
    {{ HTML::script('public/js/groups.js') }}
@stop

@section('content')

@stop
