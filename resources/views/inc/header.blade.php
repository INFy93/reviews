<header class="main-header py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
      <div class="col-4 pt-1">
        @if(Auth::check() && Auth::user()->is_admin)
      <a href="/dashboard"><img class="logo" src="{{asset('storage/images/logo.png')}}" alt="logo"></a>
        @else
        <a href="/"><img class="logo" src="{{asset('storage/images/logo.png')}}" alt="logo"></a>
        @endif
      </div>
      <div class="col-4 text-center">
        <h4 class="blog-header-logo text-dark gigabyte-title">ООО ЦРИТ Гигабайт</h4>
      </div>
      <div class="col-4 d-flex justify-content-end align-items-center">
        @if(Auth::check())
        <a class="btn btn-sm btn-outline-secondary" href="{{route('logout')}}">Выйти</a>
        @else
        <a class="btn btn-sm btn-outline-secondary" href="{{route('login')}}">Войти</a>
        @endif
      </div>
    </div>
  </header>
  @if(Auth::check())
  <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
  <h5 class="my-0 mr-md-auto font-weight-normal"><i class="fa fa-user"></i> {{Auth::user()->name}}</h5>
    <nav class="my-2 my-md-0 mr-md-3">
    @if(Auth::user()->is_admin)
    <a class="p-2 text-dark" href="{{route('test')}}">Тесты Vue.js (ЖЕНЯ НЕ ТЫКАЙ СЮДА)</a>
    <a class="p-2 text-dark" href="{{route('dashboard')}}"><strong>Управление отзывами</strong></a>
    <a class="p-2 text-dark" href="{{route('stats')}}">Статистика</a>
    <a class="p-2 text-dark" href="{{route('view-actions')}}">Настройка действий</a>
    <a class="p-2 text-dark" href="{{route('artisan')}}">Artisan</a>
    <a class="p-2 text-dark" href="{{route('get-logs')}}">Логи</a>
    @else
      <a class="p-2 text-dark" href="#" data-toggle="modal" data-target="#addReview">Добавить отзыв</a>
      <a class="p-2 text-dark" href="{{route('user-reviews')}}">Мои отзывы</a>
    @endif
    </nav>
  </div>
  @endif
