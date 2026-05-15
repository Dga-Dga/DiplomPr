<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title'  => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price'  => 'required|numeric|min:0',
            'genre'  => 'required|string|max:255',
            // 'image'  => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ];

        if ($this->isMethod('post')){
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        }

        if($this->isMethod('put') || $this->isMethod('patch')){
            $rules['image'] = 'nullable|image';
        }

        return $rules;
    }
}