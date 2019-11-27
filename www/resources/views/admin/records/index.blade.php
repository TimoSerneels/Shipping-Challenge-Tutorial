@extends('layouts.template')

@section('title', 'Records (admin)')

@section('main')
    <h1>Records</h1>

    <ul>
        @foreach ($records as $record)
            <li>{!! $record !!}</li>
        @endforeach
    </ul>
@stop
