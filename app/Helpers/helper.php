<?php

namespace App\Helpers;

use App\Models\Review;
use App\User;
use DateTime;
use Illuminate\Support\Facades\Http;
class Features
{
    public static function pureDate($date)
    {
        $current_year = date('Y'); //текущий год
        $review_year = date('Y', strtotime($date)); //год отзыва
        $review_month = date('n', strtotime($date)); //месяц отзыва в числовом формате
        $review_time = date('H:i', strtotime($date)); //время отзыва в формате 12:00

        if ($current_year == $review_year) //если текущий год равен году отзыва, то...
        {
            $year = ''; //не выводим его...
        } else {
            $year = ' ' . $review_year; //иначе = выводим
        }

        switch ($review_month) { //выводим корректно названия месяцев. можно было бы массивом, но мне лень.
            case 1:
                $month = ' января';
                break;
            case 2:
                $month = ' февраля';
                break;
            case 3:
                $month = ' марта';
                break;
            case 4:
                $month = ' апреля';
                break;
            case 5:
                $month = ' мая';
                break;
            case 6:
                $month = ' июня';
                break;
            case 7:
                $month = ' июля';
                break;
            case 8:
                $month = ' августа';
                break;
            case 9:
                $month = ' сентября';
                break;
            case 10:
                $month = ' октября';
                break;
            case 11:
                $month = ' ноября';
                break;
            case 12:
                $month = ' декабря';
                break;

            default:
                $month = $review_month;
        }

        return date('j', strtotime($date)) . $month . $year . ' в ' . $review_time; //выводим

    }

    private static function number($n, $titles) {
        $cases = array(2, 0, 1, 1, 1, 2);
        return $titles[($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[min($n % 10, 5)]];
    }

    public static function interval($user_id) //считаем стаж юзера
    {
        $now = now();
        $user_data = User::where('id', $user_id)->first();
        $reg_user_date = $user_data['reg_date'];
        $date_now = new DateTime($now);
        $date_user = new DateTime($reg_user_date);

        $interval = $date_now->diff($date_user);
        $result = '';
        if ($interval->y) { $result .= $interval->format("%y ". self::number($interval->y, array('год', 'года', 'лет'))); };
        if ($interval->m) { $result .= $interval->format(", %m ". self::number($interval->m, array('месяц', 'месяца', 'месяцев'))); }
        if ($interval->d)
        {
            if ($interval->m >= 1)
            {
                $result .= $interval->format(" и %d ". self::number($interval->d, array('день', 'дня', 'дней')));
            } else
            {
                $result .= " меньше месяца";
            }
        }
        return $result;
    }

    public static function getUserReviewCount($id) //получаем кол-во отзывов конкретного юзера для сводной таблицы
    {
        $user_review_conut = Review::where('user_id', '=', $id)->count();

        return $user_review_conut;
    }


    public static function getAvgMark($id)
    {
        $query = Review::where('user_id', '=', $id)->get();

        $avg_mark = round($query->avg('mark'), 2);

        return $avg_mark;
    }

    public static function getUserIp($user_id)
    {
        $query = Review::where('user_id', '=', $user_id)
            ->latest()
            ->first();
        //dd($query);
        if ($query != null)
        {
            $ip = $query['ip'];
            return $ip;
        }
        else return '0.0.0.0';
    }

    public static function checkGigabyteUser($login, $password)
    {
        $checkUser = Http::asForm()->post(env('CHECK_LINK'), [
            'user' => $login,
            'password' => $password,
        ]);
        if ($checkUser != '0') {
            return $checkUser;
        } else
        {
            return false;
        }
    }
}
