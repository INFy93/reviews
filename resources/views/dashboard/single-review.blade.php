@extends('layouts.app')
@section('title')Редактировать отзыв @endsection

@section('content')
<div class="col-md-12 shadow p-3 mb-5 bg-white rounded review-block">
    <h5><span class="badge badge-primary"> {{ $review->mark }} </span> {{ $review->title }}</h5> @if ($review->is_moderate == 0)<a class="badge badge-success" href="#" id={{$review->id}} onclick="moderate(this)">Одобрить</a>@else<a class="badge badge-warning" href='#' id={{$review->id}} onclick="moderate(this)">Отправить на модерацию</a>@endif <a class="badge badge-primary" href="{{ route('edit-review', $review->id) }}">Редактировать</a> <a class="badge badge-danger" id={{$review->id}} href="#" onclick="deleteReview(this)">Удалить</a> | <span class="badge badge-info"> {{ $review->ip }} </span>
            <div class="user-info">
                Добавил: <strong>{{ $review->name }},</strong> {{ Features::pureDate($review->created_at) }}
            </div>
            <div class="review-text">
                {{ $review->text }}
            </div>
            <hr>
            <small><em>Последнее действие над отзывом: <strong>{{ $last_action->type_name }}</strong></em></small>

    </div>
@endsection
