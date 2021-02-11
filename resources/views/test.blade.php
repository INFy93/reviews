@extends('layouts.app')
@section('title')Тест@endsection

@section('content')

Тест ответа: {{checkGigabyteUser('infy', 'r703992023')}}

@if ($responce->serverError())
    {{$responce->serverError()}}
@endif
@endsection
