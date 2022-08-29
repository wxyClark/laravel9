<?php


namespace App\Enums;


class HttpErrorCodeEnums
{
    const REQUEST_SUCCESS = '20000';  //

    const REQUEST_MOVED_PERMANENTLY = '30100';  //  永久重定向
    const REQUEST_REDIRECT = '30200';  //  临时重定向
    const REQUEST_NOT_MODIFIED = '30400';  //  命中缓存

    const RESPONSE_SUCCESS = '40000';  //  响应成功
    const UNAUTHORIZED = '40100';  //  未授权
    const FORBIDDEN = '40300';  //  无权访问
    const NOT_FOUND = '40400';  //  未找到
    const METHOD_NOT_ALLOWED = '40500';  //  请求方式错误(GET POST PUT HEAD DELETE)
    const REQUEST_TIMEOUT = '40800';  //  请求超时

    const INTERNAL_SERVER_ERROR = '50000';  //  内部服务器错误
    const BAD_GATEWAY = '50200';  //  网关错误
    const SERVICE_UNAVAILABLE = '50300';  //  服务不可用
    const GATEWAY_TIMEOUT  = '50400';  //  网关超时
    const HTTP_VERSION_NOT_SUPPORTED  = '50500';  //  HTTP版本不受支持

    public static $codeToMsgMap = [
        self::REQUEST_SUCCESS => '请求成功',

        //  重定向
        self::REQUEST_MOVED_PERMANENTLY => '永久重定向', //  新的URL会在响应的Location:头字段里找到
        self::REQUEST_REDIRECT => '临时重定向', //  新的URL会在响应的Location:头字段里找到
        self::REQUEST_NOT_MODIFIED => '命中缓存', //

        //  客户端错误
        self::RESPONSE_SUCCESS => '响应成功',
        self::UNAUTHORIZED => '未授权',
        self::FORBIDDEN => '无权访问',
        self::NOT_FOUND => '路由不存在',
        self::METHOD_NOT_ALLOWED => '请求方式错误',
        self::REQUEST_TIMEOUT => '请求超时',

        //  服务器端错误
        self::INTERNAL_SERVER_ERROR => '未知错误',
        self::BAD_GATEWAY => '网关错误',    //  服务器作为网关且从上游服务器获取到了一个无效的HTTP响应
        self::SERVICE_UNAVAILABLE => '服务不可用',    //  由于临时的服务器维护或者过载
        self::GATEWAY_TIMEOUT => '网关超时',    //  服务器作为网关且不能从上游服务器及时的得到响应返回给客户端
        self::HTTP_VERSION_NOT_SUPPORTED => 'HTTP版本不受支持',    //  服务器不支持客户端发送的HTTP请求中所使用的HTTP协议版本
    ];
}
