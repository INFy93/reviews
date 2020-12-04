<?php

namespace App\Http\Controllers;
use App\Models\Event_type;
use Illuminate\Http\Request;

class ActionsController extends Controller
{
    public function getAllActions()
    {
        $actions = Event_type::get();

        return view('dashboard.actions', ['actions' => $actions]);
    }

    public function addAction(Request $request)
    {
        $new_action = new Event_type();

        $new_action->type_name = $request->input('name');

        $new_action->save();

        toastr()->success('Действие было успешно добавлено');

        return redirect()->route('view-actions');
    }
}
