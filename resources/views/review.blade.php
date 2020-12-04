@extends('layouts.app')

@section('title')Отзывы@endsection

@section('content')
<div class="col-md-12">
    <h2 class="main-title">Отзывы</h2>
    <div class="count">
      Всего отзывов: {{$userReview->count()}}
    </div>
</div>

    @forelse($userReview as $review)
    <div class="col-md-3">
      <div class="user-data">
        <span class="badge badge-{{checkMark($review->mark)}}">{{$review->mark}}</span> </h1>{{$review->name}}, {{correctDate($review->created_at)}}
      </div>
      <hr style="width: 100%; color: black; height: 1px; background-color:black;" />
      {{ $review->text }}
  </div>
    @empty
    <div class="col-md-12">
        <div class="alert alert-danger message">
            У вас пока нет ни одного отзыва.
        </div>
    </div>
    @endforelse
    <!-- окошко для вывода описания/уведомлений -->
    	<div class="modal fade" id="addReview" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    	  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    	    <div class="modal-content">
    	      <div class="modal-header">
    	        <h5 class="modal-title">Добавить отзыв</h5>
    	        <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
    	          <span aria-hidden="true">&times;</span>
    	        </button>
    	      </div>
    	      <div class="modal-body">
              @if(Auth::check())
              <form data-toggle="validator" method="post" action="{{ route('add-review') }}">
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{Auth::id()}}">
                <div class="form-group">
                  <label for="name">Ваше имя</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Введите ваше имя"  minlength="3" maxlength="25" required>
                  <small id="nameHelp" class="form-text text-muted">Минимум 3 и максимум 25 символов.</small>
                </div>
                <div class="form-group">
                  <label for="title">Заголовок отзыва</label>
                  <input type="text" class="form-control" id="title" name="title" placeholder="Введите заголовок отзыва"minlength="5" maxlength="50" required>
                  <small id="titleHelp" class="form-text text-muted">Кратко опишите, о чем Ваш отзыв (минимум 5 и максимум 50 символов).</small>
                </div>
                <div class="form-group">
                  <label for="text">Текст отзыва</label>
                  <textarea class="form-control" id="text" name="text" rows="3" minlength="10" maxlength="500" required></textarea>
                  <small id="textHelp" class="form-text text-muted">Минимум 10 и максимум 500 символов.</small>
                </div>
                <div class="form-group">
                  <label for="mark">Поставьте оценку</label>
                  <select class="form-control" id="mark" name="mark">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option selected>5</option>
                  </select>
                </div>

                <button type="submit" class="btn btn-primary">Добавить отзыв</button>
              </form>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              @else
                <div class="alert alert-danger message">
                  Вы должны <a href="{{ route('login') }}">войти</a>, чтобы добавить отзыв.
                </div>
              @endif

    	      </div>
    	    </div>
    	  </div>
    	</div>

@endsection
