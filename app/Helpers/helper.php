<?php

use App\Models\Review;

if (!function_exists('pureDate'))
{
    function pureDate($date)
    {
        $current_year = date('Y'); //текущий год
        $review_year = date('Y', strtotime($date)); //год отзыва
        $review_month = date('n', strtotime($date)); //месяц отзыва в числовом формате
        $review_time = date('H:i', strtotime($date)); //время отзыва в формате 12:00

        if ($current_year == $review_year) //если текущий год равен году отзыва, то...
        {
            $year = ''; //не выводим его...
        } else
        {
            $year = ' '.$review_year; //иначе = выводим
        }

        switch($review_month)
        { //выводим корректно названия месяцев. можно было бы массивом, но мне лень.
            case 1: $month = ' января'; break;
            case 2: $month = ' февраля'; break;
            case 3: $month = ' марта'; break;
            case 4: $month = ' апреля'; break;
            case 5: $month = ' мая'; break;
            case 6: $month = ' июня'; break;
            case 7: $month = ' июля'; break;
            case 8: $month = ' августа'; break;
            case 9: $month = ' сентября'; break;
            case 10: $month = ' октября'; break;
            case 11: $month = ' ноября'; break;
            case 12: $month = ' декабря'; break;

            default: $month = $review_month;
        }

        return date('j', strtotime($date)).$month.$year.' в '.$review_time; //выводим

    }
}

if (!function_exists('getUserReviewCount')) //получаем кол-во отзывов конкретного юзера для сводной таблицы
{
    function getUserReviewCount($id)
    {
        $user_review_conut = Review::where('user_id', '=', $id)->count();

        return $user_review_conut;
    }
}

if (!function_exists('getAvgMark'))
{
    function getAvgMark($id)
    {
        $query = Review::where('user_id', '=', $id)->get();

        $avg_mark = $query->avg('mark');

        return $avg_mark;
    }
}

if (!function_exists('getUserIp'))
{
    function getUserIp($user_id)
    {
        $query = Review::where('user_id', '=', $user_id)
        ->latest()
        ->first();
        $ip = $query['ip'];
        return $ip;
    }
}

if (!function_exists('checkGigabyteUser'))
{
    function checkGigabyteUser($login, $password)
    {
        $checkUser = Http::asForm()->post('https://billing.crimeastar.net/admin/user_check.php', [
            'user' => $login,
            'password' => $password,
        ]);
        if ($checkUser == '1')
        {
           return true;
        }
    }

}
