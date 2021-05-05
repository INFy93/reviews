@extends('admin-layout.admin-app')
@section('title')Сводная информация @endsection

@section('content')
                        <h1 class="mt-4">Сводная информация</h1>
                        <div class="row">
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Всего отзывов</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        {{ $reviews_count }}
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Всего пользователей (не админов)</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        {{ $users_count }}
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Средняя оценка</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        {{ $avg_mark }}
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Сводная таблица
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered stats" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID юзера</th>
                                                <th>Имя</th>
                                                <th>Кол-во отзывов</th>
                                                <th>Средняя оценка юзера</th>
                                                <th>Впервые зашел</th>
                                                <th>IP последнего действия</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($user_info as $users)

                                            <tr>
                                                <td>{{ $users->id }}</td>
                                                <td>{{ $users->name }}</td>
                                                <td><a href="{{route('users-reviews', $users->id)}}">{{ Features::getUserReviewCount($users->id) }}</a></td>
                                                <td>{{ Features::getAvgMark($users->id) }}</td>
                                                <td>{{ Features::pureDate($users->created_at) }}</td>
                                                <td>{{ Features::getUserIp($users->id) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/a_functions.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>

@endsection
