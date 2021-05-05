<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use App\Models\Admin_action;
use App\Models\User_action;
//use App\Models\Event_type;

class LogsController extends Controller
{
    public function getLogs() //получаем все логи вместе с действиями
    {
        /* админские логи */
        $logs = Admin_action::join('event_types', 'admin_actions.action', '=', 'event_types.id')
            ->join('users', 'admin_actions.admin_id', '=', 'users.id')
            ->select('admin_actions.*', 'event_types.type_name as event_name', 'users.name as name')
            ->orderBy('admin_actions.updated_at', 'desc')
            ->get();

        /* пользовательские логи */
        $user_logs = User_action::join('event_types', 'user_actions.action', '=', 'event_types.id')
            ->join('users', 'user_actions.user_id', '=', 'users.id')
            ->select('user_actions.*', 'event_types.type_name as event_name', 'users.name as name')
            ->orderBy('user_actions.updated_at', 'desc')
            ->get();

        return view('dashboard.logs', ['logs' => $logs, 'user_logs' => $user_logs]);
    }


    public function clearLogs() //очищаем таблицу с логами
    {
        $logs = new Admin_action();

        if ($logs) {
            $logs->truncate();

            toastr()->success('Логи успешно очищены!');
        } else {
            toastr()->warning('Таблица с логами пуста! Нечего чистить :)');
        }

        return redirect()->route('get-logs');
    }

    public function clearUserLogs() //очищаем таблицу с пользовательскими логами
    {
        $logs = new User_action();

        if ($logs) {
            $logs->truncate();

            toastr()->success('Логи успешно очищены!');
        } else {
            toastr()->warning('Таблица с логами пуста! Нечего чистить :)');
        }

        return redirect()->route('get-logs');
    }

    public function deleteOneLog($log_id) //удаляем одну строчку лога
    {
        $log = Admin_action::find($log_id);

        $log->delete();
    }

    public function deleteUserLog($log_id) //удаляем одну строчку пользовательского лога
    {
        $log = User_action::find($log_id);

        $log->delete();
    }
}
