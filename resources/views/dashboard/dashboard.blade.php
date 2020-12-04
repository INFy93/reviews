@extends('layouts.app')
@section('title')Отзывы ЦРИТ Гигабайт@endsection

@section('content')
<div class="col-md-12">
    <h4 class="main-title">Управление отзывами ({{count($reviews)}})</h4>
</div>

@forelse ($reviews as $review)
    <div class="col-md-12 shadow p-3 mb-5 bg-white rounded review-block">
    <h5><span class="badge badge-primary"> {{ $review->mark }} </span> {{ $review->title }}</h5> @if ($review->is_moderate == 0)<a class="badge badge-success" href="#" id={{$review->id}} onclick="moderate(this)">Одобрить</a>@else<a class="badge badge-warning" href='#' id={{$review->id}} onclick="moderate(this)">Убрать мод.</a>@endif <a class="badge badge-primary" href="{{ route('edit-review', $review->id) }}">Редактировать</a> <a class="badge badge-danger" id={{$review->id}} href="#" onclick="deleteReview(this)">Удалить</a>
            <div class="user-info">
                Добавил: <strong>{{ $review->name }},</strong> {{ pureDate($review->created_at) }}
            </div>
            <div class="review-text">
                {{ $review->text }}
            </div>
    </div>
@empty
<div class="col-md-12">
    <div class="alert alert-danger message">
        Пока нет ни одного отзыва!
    </div>
</div>
@endforelse
{{ $reviews->links() }}

@endsection
