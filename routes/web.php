<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'ReviewController@getReviews')->name('home'); //главная страничка
Route::get('/test', 'VueController@index')->name('test'); //vue js testing
Route::get('/test/ajax', 'VueController@getJson')->name('ajax'); //ajax-запрос vue

Auth::routes(); //роуты для аунтентификации

Route::middleware('auth')->group(function () { //группа роутов для авторизованного юзера-неАдмина
    Route::post('/add-review', 'ReviewController@addReview')->name('add-review'); //добавляем отзыв

    Route::get('/reviews/my-reviews', 'ReviewController@getUserReviews')->name('user-reviews'); //просмотр отзывов конкретного юзера

    Route::get('/reviews/my-reviews/change-review/{id}', 'ReviewController@changeReview')->name('change-review'); //юзер редачит свой отзыв

    Route::post('/reviews/my-reviews/change-review/{id}/change', 'ReviewController@updateReview')->name('editing'); //пост-запрос для обновления


    Route::get('logout', 'Auth\LoginController@logout')->name('logout'); //выходим
});



Route::group(['middleware' => 'admin'], function() { //админские функции
    Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard'); //общая админка

    Route::get('/dashboard/info', 'DashboardController@getInfo')->name('stats'); //обзорная инфа по отзывам

    Route::post('/dashboard/update-review/{id}', 'DashboardController@editReview')->name('update-review'); //POST-обновление отзыва

    Route::get('/dashboard/edit-review/{id}', 'DashboardController@getReviewToEdit')->name('edit-review'); //страничка для редактирования отзыва

    Route::get('/dashboard/user-reviews/{user_id}', 'DashboardController@findUserReviews')->name('users-reviews'); //выбираем отзывы юзера для администрирования

    Route::get('/dashboard/delete-review/{review_id}', 'DashboardController@deleteReview')->name('delete-review'); //удаление отзыва

    Route::get('/dashboard/moderate/{id}', 'DashboardController@moderateReview')->name('moderate'); //изменение статуса модерации отзыва

    Route::get('/dashboard/actions', 'ActionsController@getAllActions')->name('view-actions'); //просмотр возможных действий

    Route::post('dashboard/actions/add-action', 'ActionsController@addAction')->name('add-action'); //добавление действия

    Route::get('dashboard/logs', 'LogsController@getLogs')->name('get-logs'); //просмотр логов

    Route::get('dashboard/logs/clear', 'LogsController@clearLogs')->name('clear-logs'); //очистка всех логов

    Route::get('dashboard/logs/delete-log/{id}', 'LogsController@deleteOneLog')->name('delete-log'); //удаляем одну строчку лога. AJAX

    Route::get('dashboard/review/{id}', 'DashboardController@getSingleReview')->name('single-review'); //получаем отдельный отзыв для просмотра
});
