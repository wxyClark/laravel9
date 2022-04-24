<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AfterSpecialHandle
{
    /**
     * 统一特殊业务处理
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // 触发事件监听，更新业务数据状态(如：判定是否已处理完结)
        print_r('<br>' . __METHOD__. ' | line: ' . __LINE__ . '<br>');

        return $response;
    }
}
