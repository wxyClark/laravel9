<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BeforeSpecialAuth
{
    use \App\Traits\GetParams;

    /**
     * 统一特殊权限过滤
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        print_r('<br>' . __METHOD__. ' | line: ' . __LINE__ . '<br>');

        //  调用结果获取当前登录用户的可操作权限
        //  权限为空可返回错误信息，指定权限参数 不在权限列表可发货错误信息并强制重定向
        $params = $this->getJsonParams($request, 'data');

        $params['special_auth'] = ['special', 'auth']; 

        $request->merge(['data'=>json_encode($params)]);//覆盖data数据

        return $next($request);
    }
}
