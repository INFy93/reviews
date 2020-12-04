$(document).ready(function() {
    $.ajaxSetup({ //setting AJAX
        headers: {
        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });
// Оформляем DataTable
    $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Russian.json"
        }
    });

    // Оформляем сводную таблицу
    $('table.stats').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Russian.json"
        },

        "order": [[ 4, "desc" ]]

    });

    // Оформляем таблицу с логами
    $('table.logs').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Russian.json"
        },

        "order": [[ 4, "desc" ]]

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

function deleteLog(id) {
    var dataTable;
    let row_id = $(id).closest('tr').attr('id');
    let route = '/dashboard/logs/delete-log/'+row_id;
    dataTable = $('table.logs').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Russian.json"
        },

        "order": [[ 4, "desc" ]]

    });
    if (confirm("Удалить данную запись из лога?"))
    {
        $.ajax({
            type: 'get',
            url: route
        }).done(function (html){
            $('#'+row_id).remove();
           // $(".logs").reload();
            toastr.warning('Лог успешно удален')
        }).fail(function (html) {
            toastr.error('Ошибка удаления лога')
        })
    }
}

function confirmDelete(){
    var ask=confirm("Вы действительно хотите очистить все логи?");
    if(ask){
      window.location="/dashboard/logs/clear";
     }
}
