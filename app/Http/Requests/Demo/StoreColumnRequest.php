<?php

namespace App\Http\Requests\Demo;

use Illuminate\Foundation\Http\FormRequest;

/**
 * php artisan make:request Demo/StoreColumnRequest
 */
class StoreColumnRequest extends FormRequest
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
            'data_type' => ['required|string|max:20', '数据类型'],
            'memory_size' => ['required|integer', '占用内存'], 
            'feature' => ['string', '特性'], 
        ];
    }
}
