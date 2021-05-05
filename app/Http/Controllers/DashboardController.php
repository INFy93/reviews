<?php

namespace App\Http\Controllers;

use Auth;
use Artisan;
use App\User;
use App\Models\Review;
use App\Models\Event_type;
use App\Models\Admin_action;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    { //берем все отзывы для администрирования
        $reviews = Review::orderBy('created_at', 'desc')
            ->paginate(5);
        return view('dashboard.dashboard', ['reviews' => $reviews]);
    }

    public function getReviewToEdit($review_id) //получаем отзывы по зареганному
    {
        $user_review = Review::find($review_id);

        return view('dashboard.edit-review', ['user_review' => $user_review]);
    }

    public function findUserReviews($user_id)
    {
        $users_reviews = Review::where('user_id', '=', $user_id)
        ->orderBy('created_at', 'desc')
        ->paginate(5);

        $user_info = User::find($user_id);

        return view('dashboard.user-reviews', ['reviews' => $users_reviews, 'user' => $user_info]);
    }

    public function editReview($review_id, Request $request) //редактируем отзыв
    {
        $review = Review::find($review_id);
        $admin_action = new Admin_action();

        $admin_action->admin_id = Auth::id();
        $admin_action->action = 2;
        $admin_action->review_id = $review_id;
        $admin_action->save();

        $review->name = $request->input('name');
        $review->title = $request->input('title');
        $review->text = $request->input('text');
        $review->mark = $request->input('mark');
        $review->last_action = 2;


        $review->save();

        toastr()->success('Отзыв успешно обновлен!');

        return redirect()->route('dashboard');
    }

    public function deleteReview($review_id) //удаление отзыва
    {
        $review = Review::find($review_id);
        $admin_action = new Admin_action();

        $admin_action->admin_id = Auth::id();
        $admin_action->action = 1;
        $admin_action->review_id = $review_id;
        $admin_action->save();

        $review->delete();
    }

    public function moderateReview($review_id) //модерация отзыва
    {
        $review = Review::find($review_id);
        $admin_action = new Admin_action();

        $admin_action->admin_id = Auth::id();
        $admin_action->action = 3;
        $admin_action->review_id = $review_id;
        $admin_action->save();

        $review->last_action = 3;

        if ($review->is_moderate == 1) {
            $review->is_moderate = 0;
        } else {
            $review->is_moderate = 1;
        }

        $review->save();
    }

    public function getInfo() //собираем информацию об отзывах и юзере
    {
        $reviews_count = Review::count(); //считаем отзывы

        $users_count = User::where('is_admin', '=', '0')->count(); //считаем юзеров не админов

        $avg_mark = round(Review::avg('mark'), 2); //выводим среднюю оценку

        $user_info = User::where('users.is_admin', '<>', '1')
            ->select('users.id', 'users.name', 'users.created_at')
            ->orderBy('users.created_at', 'desc')
            ->get();

        return view('dashboard.stats', ['reviews_count' => $reviews_count, 'users_count' => $users_count, 'avg_mark' => $avg_mark, 'user_info' => $user_info]);
    }

    public function getSingleReview($id) //получаем отдельный отзыв из логов и последнее действие над ним
    {
        $review = Review::find($id);
        if ($review) {
            $last_action = Event_type::find($review->last_action);

            return view('dashboard.single-review', ['review' => $review, 'last_action' => $last_action]);
        } else {
            toastr()->error('Отзыв был удален, его просмотр невозможен (спасибо, кэп)');
            return redirect()->route('get-logs');
        }
    }

    public function artisanShow()
    {
        return view('dashboard.artisan');
    }

    public function artisanCalls($action)
    {
        switch ($action) {
            case 'cache':
                Artisan::call('cache:clear'); //общий кеш
                break;

            case 'config':
                Artisan::call('config:clear'); //кеш конфигов
                break;

            case 'route':
                Artisan::call('route:clear'); //кеш роутов
                break;

            case 'view':
                Artisan::call('view:clear'); //кеш вьюшек
                break;
            case 'migrate':
                Artisan::call('migrate'); //миграции
                break;
            case 'link':
                Artisan::call('storage:link'); //симлинк
                break;

            default:
                Artisan::call('cache:clear'); //по дефолту чистим общий кеш
        }

        return Artisan::output();
    }
}
