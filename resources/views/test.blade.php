@extends('layouts.app')
@section('title')Тест@endsection

@section('content')

Тест ответа: {{checkGigabyteUser('infy', 'r70399202')}}

@if ($responce->serverError())
    {{$responce->serverError()}}
@endif
@endsection
