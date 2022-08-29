<?php


namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BaseRequest extends Request
{
    static $rules = [];

    private static $validate_messages = [
        'required' => ':attribute不能为空',
        'min' => ':attribute长度（数值）不应该小于:min',
        'max' => ':attribute长度（数值）不应该大于:max',
        'string' => ':attribute格式错误',
        'integer' => ':attribute必须为数字',
        'unique' => '该:attribute已经存在',
        'numeric' => ':attribute必须是数字',
        'array' => ':attribute参数值应该为数组',
        'in' => ':attribute不在指定范围内',
        'date_format' => ':attribute格式错误',
        'between' => ':attribute必须在:min-:max之间',
        'exists' => ':attribute不存在',
        'date' => ':attribute不是有效的日期格式',
        'alpha_new' => ':attribute 必须是字母',
        'alpha_dash_new' => ':attribute 必须是字母_-数字',
        'alpha_num_new' => ':attribute 必须是字母数字',
        'required_if' => ':attribute 不能为空',
    ];

    protected function validateParams($params, $rules)
    {
        $field_names = [];
        $rule_data = [];
        foreach ($rules as $key => $rule) {
            $rule_data[$key] = $rule[0];
            $field_names[$key] = $rule[1];
        }

        $validator = Validator::make($params, $rule_data, self::$validate_messages, $field_names);
        if ($validator->fails()) {
            $message = '';
            if ($validator->errors() && !empty($validator->errors())) {
                $params = json_decode($validator->errors(), true);
                if (!empty($params)) {
                    foreach ($params as $value) {
                        $message .= implode(',', $value) . ';';
                    }
                }
            }
            throw new \Exception($message, 40003);
        }
        return ['status' => true];

    }


}
