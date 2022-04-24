<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AfterBase
{
    /**
     * Action之后的统一处理(如：记录日志,发送通知)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        //  接口处理结果：成功?失败,执行耗时等
        print_r('<br>' . __METHOD__. ' | line: ' . __LINE__ . '<br>');

        return $response;
    }
}
