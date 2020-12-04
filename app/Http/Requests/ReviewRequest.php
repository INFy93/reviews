<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:25',
            'title' => 'required|min:5|max:50',
            'text' => 'required|min:10|max:500'
        ];
    }

    public function messages() {
      return [
            'name.required' => 'Поле "Имя" обязательно для заполнения!',
            'name.min' => 'Поле "Имя" должно содержать как минимум 3 символа.',
            'name.max' => 'Поле "Имя" может содержать максимум 25 символов.',
            'title.required' => 'Поле "Заголовок" обязательно для заполнения!',
            'title.min' => 'Заголовок должен содержать как минимум 5 символов.',
            'title.max' => 'Заголовок может содержать максимум 50 символов.',
            'text.required' => 'Необходимо ввести текст отзыва!',
            'text.min' => 'Отзыв должен содержать как минимум 10 символов.',
            'text.max' => 'Отзыв должен содержать максимум 25 символов.',
      ];
    }
}
