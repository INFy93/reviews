$(document).ready(function() {
    $.ajaxSetup({ //setting AJAX
        headers: {
        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });
    // Оформляем сводную таблицу
    $('table.stats').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Russian.json"
        },

        "order": [[ 0, "asc" ]]

    });

    // Оформляем таблицу с логами
    $('table.datatable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Russian.json"
        },

        "order": [[ 4, "asc" ]]

    });

});
function moderate(id) {
    if (confirm("Изменить статус отзыва?"))
    {
    var review_id = $(id).attr('id'); //берем id отзыва
    var route = '/dashboard/moderate/'+review_id;
    $.ajax({
        type: 'get',
        url: route
    }).done(function(html){
        if ($(id).hasClass('badge-success')) {
            $(id).removeClass('badge-success');
            $(id).addClass('badge-warning');
            $(id).text('Убрать мод.');
            toastr.success('Отзыв прошел модерацию!')
        } else if ($(id).hasClass('badge-warning')) {
            $(id).removeClass('badge-warning');
            $(id).addClass('badge-success');
            $(id).text('Одобрить');
            toastr.warning('Отзыв теперь на модерации!')
        }

    }).fail(function(html){
        toastr.error('Ошибка изменения статуса модерации. Попробуйте позже.')
    })
    }
}

function deleteReview(id) {
    if (confirm("Удалить отзыв? Эту процедуру нельзя отменить!"))
    {
        var review_id = $(id).attr('id');
    var route = '/dashboard/delete-review/'+review_id;
    $.ajax({
        type: 'get',
        url: route
    }).done(function(html) {
        $(id).parent().remove();
        toastr.warning('Отзыв успешно удален!')
    }).fail(function(html) {
        toastr.error('Ошибка удаления отзыва. Попробуйте позже.')
    })
    }

}
$(document.body).on('click', '.delete_admin_log', deleteLog);
function deleteLog() {
    var dataTable;
    var that = this;
    let row_id = $(this).closest('tr').attr('id');
    var index = $(this).closest("tr");
    let route = '/dashboard/logs/delete-log/'+row_id;
    if (confirm("Удалить данную запись из лога?"))
    {
        $.ajax({
            type: 'get',
            url: route
        }).done(function (html){
            index.hide();
            toastr.warning('Лог успешно удален')
        }).fail(function (html) {
            toastr.error('Ошибка удаления лога')
        })
    }
}
$(document.body).on('click', '.delete_user_log', deleteUserLog);
function deleteUserLog(id) {
    var dataTable;
    let row_id = $(id).closest('tr').attr('id');
    var index = $(this).closest("tr");
    let route = '/dashboard/logs/delete-user-log/'+row_id;
    if (confirm("Удалить данную запись из лога?"))
    {
        $.ajax({
            type: 'get',
            url: route
        }).done(function (html){
            index.hide();
            toastr.warning('Лог успешно удален')
        }).fail(function (html) {
            toastr.error('Ошибка удаления лога')
        })
    }
}

function confirmDelete(){
    let ask = confirm("Вы действительно хотите очистить все логи?");
    if (ask) {
      window.location="/dashboard/logs/clear";
     }
}

function confirmUserDelete(){
    let ask = confirm("Вы действительно хотите очистить все пользовательские логи?");
    if (ask) {
      window.location="/dashboard/user-logs/clear";
     }
}

function clearCache(i) {
    let action = $(i).attr('id');
    let route = '/dashboard/artisan/' + action;

    $.ajax({
        type: 'GET',
        url: route,
    }).done(function (result) {
            answer = result;
            toastr.success('Успех: ' + answer);
    }).fail(function(result) {
        answer = result;
        toastr.error('Ошибка: ' + answer);
    });
}
