@extends('layouts.app')
@section('title')Отзывы ЦРИТ Гигабайт@endsection

@section('content')
@forelse ($reviews as $review)
    <div class="col-md-12 shadow p-3 mb-5 bg-white rounded review-block">
        <h5>
            {{ $review->title }}
            @for ($i = 0; $i < $review->mark; $i++)
                <i class="fa fa-star"></i>
            @endfor
        </h5>  @if ($review->is_moderate == 0) <span class="badge badge-warning"> На модерации! </span> @endif
            @if (Auth::check() && Auth::user()->is_admin)
            <a class="badge badge-primary" href="{{ route('edit-review', $review->id) }}">Редактировать отзыв</a>
            <a class="badge badge-danger" id={{$review->id}} href="#" onclick="deleteReview(this)">Удалить</a>
            @endif
            <div class="user-info">
            <i class="fa fa-user"></i> <strong>{{ $review->name }} </strong> <br>
            <i class="far fa-clock"></i>  {{ pureDate($review->created_at) }}
            </div>
            <div class="review-text">
                {{ $review->text }}
            </div>
    </div>
    <hr />
@empty
<div class="col-md-12">
    <div class="alert alert-danger message">
        Пока нет ни одного отзыва!
    </div>
</div>
@endforelse
{{ $reviews->links() }}
<!-- Вывод окошка с добавлением отзыва -->
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
              <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" minlength="3" maxlength="30" placeholder="Введите ваше имя" required>
              <small class="form-text text-muted">От 3 до 30 символов.</small>
            </div>
            <div class="form-group">
              <label for="title">Заголовок</label>
              <input type="text" class="form-control" id="title" name="title" minlength="5" maxlength="50" placeholder="Заголовок отзыва" required>
              <small class="form-text text-muted">От 5 до 50 символов.</small>
            </div>
            <div class="form-group">
                    <label for="text">Текст отзыва</label>
                    <textarea class="form-control" id="text" name="text" rows="5" minlength="10" maxlength="1000" placeholder="Введите текст отзыва" required></textarea>
                <small class="form-text text-muted">От 10 до 1000 символов.</small>
            </div>
            <div class="form-group">
                <label for="mark">Поставьте оценку</label>
                <select class="form-control" id="mark" name="mark" required>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option selected>5</option>
                </select>
              </div>
            <button type="submit" class="btn btn-primary">Отправить</button>
          </form>
        </div>
      </div>
    </div>
  </div>


@endsection
