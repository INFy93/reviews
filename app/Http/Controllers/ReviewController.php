<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Review;
use App\Models\User_action;
use Illuminate\Support\Facades\Http;
use Auth;

class ReviewController extends Controller
{
    public function getReviews() //на главную страничку выводим только отмодерированные отзывы! но если админ, то выводим все.
    {
        if (Auth::check() && Auth::user()->is_admin) {
            $reviews = Review::orderBy('created_at', 'desc')
                ->paginate(5);
        } else {
            $reviews = Review::where('is_moderate', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }

        return view('home', ['reviews' => $reviews]);
    }

    public function addReview(Request $request) //добавляем отзыв
    {
        $new_review = new Review();
        $user_log = new User_action();

        $new_review->user_id = Auth::id();
        $new_review->name = $request->input('name');
        $new_review->title = $request->input('title');
        $new_review->text = $request->input('text');
        $new_review->mark = $request->input('mark');
        $new_review->ip = $request->ip();
        $new_review->last_action = 4;
        $new_review->save();

        $user_log->user_id = Auth::id();
        $user_log->action = 4;
        $user_log->review_id = $new_review->id;
        $user_log->save();

        toastr()->success('Ваш отзыв успешно добавлен и находится на модерации');

        return redirect()->route('user-reviews');
    }

    public function getUserReviews() //получаем отзывы по зареганному
    {
        $user_reviews = Review::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('my_reviews', ['user_reviews' => $user_reviews]);
    }

}
