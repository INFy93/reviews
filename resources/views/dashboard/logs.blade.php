@extends('admin-layout.admin-app')
@section('title')Логи @endsection
@section('content')
<div class="col-md-12">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#admin_logs">Действия администраторов</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#user_logs">Пользовательские логи</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="admin_logs" class="tab-pane fade show active">
            <div class="table-responsive">
                <table class="table table-bordered datatable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>№ записи</th>
                            <th>Админ</th>
                            <th>Действие</th>
                            <th>ID отзыва</th>
                            <th>Время операции</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($logs as $log)

                        <tr id="{{ $log->id  }}">
                            <td>{{ $log->id }}</td>
                            <td>{{ $log->name }}</td>
                            <td>{{ $log->event_name }}</td>
                            <td><a href="{{ route('single-review', $log->review_id) }}">{{ $log->review_id }}</a> | <a
                                    href="#"  class="delete_admin_log">Удалить эту запись лога</a> </td>
                            <td>{{ Features::pureDate($log->updated_at) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">В логах ничего нет.</td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                            <td style="display: none;"></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @isset($log)
                <a class="btn btn-primary" href="#" onclick="confirmDelete()" role="button">Очистить логи</a>
                @endisset
            </div>
        </div>
        <div id="user_logs" class="tab-pane fade">
            <div id="admin_logs" class="tab-pane fade show active">
                <div class="table-responsive">
                    <table class="table table-bordered datatable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>№ записи</th>
                                <th>Юзер</th>
                                <th>Действие</th>
                                <th>ID отзыва</th>
                                <th>Время операции</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($user_logs as $log)

                            <tr id="{{ $log->id  }}">
                                <td>{{ $log->id }}</td>
                                <td>{{ $log->name }}</td>
                                <td>{{ $log->event_name }}</td>
                                <td><a href="{{ route('single-review', $log->review_id) }}">{{ $log->review_id }}</a> | <a
                                        href="#" class="delete_user_log">Удалить эту запись лога</a> </td>
                                <td>{{ Features::pureDate($log->updated_at) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">В логах ничего нет.</td>
                                <td style="display: none;"></td>
                                <td style="display: none;"></td>
                                <td style="display: none;"></td>
                                <td style="display: none;"></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @isset($log)
                    <a class="btn btn-primary" href="#" onclick="confirmUserDelete()" role="button">Очистить логи</a>
                    @endisset
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
