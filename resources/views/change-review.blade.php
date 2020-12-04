@extends('layouts.app')
@section('title')Редактировать отзыв@endsection

@section('content')
    <div class="col-md-12">
        <h4 class="main-title">Редактировать отзыв</h4>
    </div>
    <div class="col-md-12">
        <form method="POST" action="{{route('editing', $user_review->id)}}">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="title">Заголовок</label>
                <input type="text" class="form-control" id="title" name="title" minlength="5" maxlength="40"
                    value="{{ $user_review->title }}" required>
                <small class="form-text text-muted">От 5 до 40 символов.</small>
            </div>
            <div class="form-group">
                <label for="text">Текст отзыва</label>
                <textarea class="form-control" id="text" name="text" rows="5" minlength="10" maxlength="1000"
                    placeholder="Введите текст отзыва" required>{{ $user_review->text }}</textarea>
                <small class="form-text text-muted">От 10 до 1000 символов.</small>
            </div>
            <button type="submit" class="btn btn-primary">Обновить отзыв</button>
        </form>
        <br>
        <a href="{{ route('user-reviews') }}">Вернуться назад</a>
    </div>
@endsection
