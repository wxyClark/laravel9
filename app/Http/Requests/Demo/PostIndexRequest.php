<?php

namespace App\Http\Requests\Demo;

use Illuminate\Http\Request;

class PostIndexRequest extends Request
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
            'time_type' => ['string|in:created_at,updated_at','时间类型'],
            'time_start' => ['date','开始时间'],
            'time_end' => ['date','结束时间'],

            //  筛选项 尽可能使用精准匹配，并支持数组
            'handler_type' => ['string|in:created_by,updated_by,xx_operator', '操作人类型'],
            'handler_names' => ['array|max:200', '操作人 数组'],
            'handler_names.*' => ['string|max:25', '操作名称'],

            //  模糊筛选要尽量少，尽可能使用 like 'keywords%'匹配
        ];
    }
}
