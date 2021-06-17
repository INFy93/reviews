@extends('layouts.app')
@section('title')Ваши отзывы@endsection

@section('content')
<div class="col-md-12">
    <h4 class="main-title">Мои отзывы ({{Features::getUserReviewCount(Auth::id())}})</h4>
</div>

@forelse ($user_reviews as $review)
<div class="col-md-12 col-md-12 shadow p-3 mb-5 bg-white rounded review-block">
    <h5><span class="badge badge-primary"> {{ $review->mark }} </span> {{ $review->title }} </h5>
        @if ($review->is_moderate == 0)
       Статус отзыва: <span class="badge badge-warning"> На модерации </span>
        @else
       Статус отзыва: <span class="badge badge-success"> Одобрено </span>
        @endif

    <div class="user-info">
        <i class="fa fa-user"></i> <strong>{{ $review->name }} </strong> <br>
        <i class="far fa-clock"></i>  {{ Features::pureDate($review->created_at) }}
        </div>
        <div class="review-text">
            {{ $review->text }}
        </div>
</div>
@empty
<div class="col-md-12">
    <div class="alert alert-danger message">
        У вас пока нет ни одного отзыва.
    </div>
</div>

@endforelse
<div class="modal fade" id="addReview" tabindex="-1" role="dialog" aria-labelledby="reviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Добавление отзыва</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form method="POST" action="{{ route('add-review') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="name">Имя</label>
              <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" minlength="3" maxlength="40" placeholder="Введите ваше имя" required>
              <small class="form-text text-muted">От 3 до 40 символов.</small>
            </div>
            <div class="form-group">
              <label for="title">Заголовок</label>
              <input type="text" class="form-control" id="title" name="title" minlength="5" maxlength="40" placeholder="Заголовок отзыва" required>
              <small class="form-text text-muted">От 5 до 40 символов.</small>
            </div>
            <div class="form-group">
                    <label for="text">Текст отзыва</label>
                    <textarea class="form-control" id="text" name="text" rows="5" minlength="10" maxlength="1000" placeholder="Введите текст отзыва" required></textarea>
                <small class="form-text text-muted">От 10 до 1000 символов.</small>
            </div>
            <label for="rate">Поставьте оценку:</label>
            <div class="markers">
                <i class="rate fas fa-star"></i><i class="rate fas fa-star"></i><i class="rate fas fa-star"></i><i class="rate fas fa-star"></i><i class="rate fas fa-star"></i>
                <div class="count"><strong>(5)</strong></div>
            </div>
            <input type="hidden" id="mark" name="mark" value="5">
            <button type="submit" class="btn btn-primary">Отправить</button>
          </form>
@endsection
