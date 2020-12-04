<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VueController extends Controller
{
    public function index()
    {
        $url_data = [
            array(
                'title' => 'Google',
                'url' => 'google.com'
            ),
            array(
                'title' => 'Yandex',
                'url' => 'ya.ru'
            )
            ];
        return view('test_vue', ['url_data' => $url_data]);
    }

    public function getJson()
    {
        return [
            array(
                'title' => 'Google vv',
                'url' => 'google.com'
            ),
            array(
                'title' => 'Yandex',
                'url' => 'ya.ru'
            ),
            array(
                'title' => 'Vk',
                'url' => 'vk.com'
            )
            ];
    }
}
