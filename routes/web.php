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
//роуты для нового логина/регистрации
Route::get('/enter', 'Auth\LoginController@showLoginForm')->name('enter');
Route::post('/enter', 'Auth\LoginController@login')->middleware("throttle:5,2")->name('login');

Route::middleware('auth')->group(function () { //группа роутов для авторизованного юзера-неАдмина
    Route::post('/add-review', 'ReviewController@addReview')->name('add-review'); //добавляем отзыв

    Route::get('/reviews/my-reviews', 'ReviewController@getUserReviews')->name('user-reviews'); //просмотр отзывов конкретного юзера

    Route::get('/reviews/my-reviews/change-review/{id}', 'ReviewController@changeReview')->name('change-review'); //юзер редачит свой отзыв

    Route::post('/reviews/my-reviews/change-review/{id}/change', 'ReviewController@updateReview')->name('editing'); //пост-запрос для обновления


    Route::get('logout', 'Auth\LoginController@logout')->name('logout'); //выходим
});



Route::group(['middleware' => 'admin', 'prefix' => 'dashboard'], function() { //админские функции
    Route::get('/', 'DashboardController@dashboard')->name('dashboard'); //общая админка

    Route::get('/info', 'DashboardController@getInfo')->name('stats'); //обзорная инфа по отзывам

    Route::post('/update-review/{id}', 'DashboardController@editReview')->name('update-review'); //POST-обновление отзыва

    Route::get('/edit-review/{id}', 'DashboardController@getReviewToEdit')->name('edit-review'); //страничка для редактирования отзыва

    Route::get('/user-reviews/{user_id}', 'DashboardController@findUserReviews')->name('users-reviews'); //выбираем отзывы юзера для администрирования

    Route::get('/delete-review/{review_id}', 'DashboardController@deleteReview')->name('delete-review'); //удаление отзыва

    Route::get('/moderate/{id}', 'DashboardController@moderateReview')->name('moderate'); //изменение статуса модерации отзыва

    Route::get('/actions', 'ActionsController@getAllActions')->name('view-actions'); //просмотр возможных действий

    Route::post('/actions/add-action', 'ActionsController@addAction')->name('add-action'); //добавление действия

    Route::get('/logs', 'LogsController@getLogs')->name('get-logs'); //просмотр логов

    Route::get('/logs/clear', 'LogsController@clearLogs')->name('clear-logs'); //очистка всех логов

    Route::get('/user-logs/clear', 'LogsController@clearUserLogs')->name('clear-user-logs'); //очистка всех пользовательских логов

    Route::get('/logs/delete-log/{id}', 'LogsController@deleteOneLog')->name('delete-log'); //удаляем одну строчку лога. AJAX

    Route::get('/logs/delete-user-log/{id}', 'LogsController@deleteUserLog')->name('delete-user-log'); //удаляем одну строчку пользовательского лога. AJAX

    Route::get('/review/{id}', 'DashboardController@getSingleReview')->name('single-review'); //получаем отдельный отзыв для просмотра

    Route::get('/artisan', 'DashboardController@artisanShow')->name('artisan'); //страница для управления командами artisan

    Route::get('/artisan/{action}', 'DashboardController@artisanCalls')->name('artisan-calls'); //действия для artisan
});
