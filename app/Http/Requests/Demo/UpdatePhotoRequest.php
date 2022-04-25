<?php

namespace App\Http\Requests\Demo;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhotoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url' => ['required|string|max:255', '图片url'],
            'type' => ['required|integer|max:255', '图片类型'], 
            'updated_at' => ['integer|max:255', '更新时间(时间戳)'], 
        ];
    }
}
