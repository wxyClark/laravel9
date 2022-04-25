<?php

namespace App\Http\Requests\Demo;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 生成资源 controller 时，只有指定model的情况下，指定 --requests 才会生成 XxxRequest 文件
 * php artisan make:controller Demo/PostController --model=Post --resource --requests
 * 
 * 建议的操作顺序：
 * 1、php artisan make:model Path/ModelName --migration
 * 2、php artisan make:request Path/RequestName
 * 3、php artsian make:controller Path/NameController --resource
 * 4、配置路由
 */
class UpdatePostRequest extends FormRequest
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
            //
        ];
    }
}
