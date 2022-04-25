<?php

namespace App\Http\Requests\Demo;

use Illuminate\Foundation\Http\FormRequest;

class StorePhotoRequest extends FormRequest
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
            'created_at' => ['integer|max:255', '创建时间(时间戳)'], 
        ];
    }
}
