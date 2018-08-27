<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'title' => 'required|max:255',
          'text' => 'required',
          'image' => 'required|image|mimes:jpeg,gif,png|max:2048',
          'tags' => 'required',
          'category' => 'required'
        ];
    }
    
    public function messages()
    {
        return [
            'title.required' => "Обязательное поле",
            'title.max' => "Максимальное кол-во символов - 255",
            'text.required' => "Обязательное поле",
            'image.required'  => "Добавьте фото",
            'image.image'  => "Допустимые форматы файлов: JPG, JPEG, GIF, PNG.",
            'image.mimes'  => "Допустимые форматы файлов: JPG, JPEG, GIF, PNG.",
            'image.max'    => "Максимальный размер фото: 2 MB.",
            'tags.required'  => "Обязательное поле",
            'category.required'  => "Обязательное поле"
        ];
    }
}
