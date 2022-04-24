<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BeforeBase
{
    use \App\Traits\GetParams;

    /**
     *  执行Action之前的统一处理(如 校验全局必填参数：租户ID,用户ID; 通过可信任的入参获取相关数据)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        print_r('<br>' . __METHOD__. ' | line: ' . __LINE__ . '<br>');

        //  校验参数，补充参数
        $params = $this->getJsonParams($request, 'data');
        $customerId = $params['customerId'] ?? 0;   //  缺少应判定未非法请求
        $userId = $params['userId'] ?? 0;   //  缺少应判定未非法请求
        $user_name = $this->getUserName($customerId, $userId);
        empty($user_name ) && $user_name = 'system';
        $params['user_name'] = $user_name;

        $request->merge(['data'=>json_encode($params)]);//覆盖data数据
        return $next($request);
    }

    /**
     * 获取用户名
     */
    private function getUserName($customerId, $userId)
    {
        return '';
    }
}
