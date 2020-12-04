@extends('admin-layout.admin-app')
@section('title')Редактирование действий@endsection

@section('content')
<div class="col-md-12">
    <h3 class="mt-4">Управление действиями</h1>
</div>
<div class="card mb-12">
    <div class="card-header">
        <i class="fas fa-table mr-1"></i>
       Действия
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID действия</th>
                        <th>Название</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($actions as $action)

                    <tr>
                        <td>{{ $action->id }}</td>
                        <td>{{ $action->type_name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a class="btn btn-primary" href="#" href="#" data-toggle="modal" data-target="#addAction" role="button">Добавить действие</a>
        </div>
    </div>
</div>
<!-- Вывод окошка с добавлением действия -->
<div class="modal fade" id="addAction" tabindex="-1" role="dialog" aria-labelledby="reviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Добавление действия</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form method="POST" action="{{ route('add-action') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="name">Название действия</label>
              <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" minlength="3" maxlength="50" placeholder="Введите название действия" required>
              <small class="form-text text-muted">От 3 до 50 символов.</small>
            </div>
            <button type="submit" class="btn btn-primary">Добавить действие</button>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection
