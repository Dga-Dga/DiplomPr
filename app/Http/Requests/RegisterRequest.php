<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // разрешаем всем
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'phone'    => 'nullable|string|max:11',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Введите своё имя',
            'email.required'     => 'Введите свой email',
            'email.email'        => 'Неправильный формат email',
            'email.unique'       => 'Пользователь с таким email уже зарегистрирован',
            'password.required'  => 'Введите пароль',
            'password.min'       => 'Пароль должен быть не менее 8 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ];
    }
}