<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //  默认分页参数
    const DEFAULT_PAGE_INDEX = 1;
    const DEFAULT_PAGE_SIZE = 20;

    /**
     * 打印当前路由的 controller@action
     */
    protected function printMethod()
    {
        print_r('<br>' . request()->route()->getActionName() . '<br>');
    }

    /**
     * @desc    获取页码
     * @param $params
     * @param string $key
     * @return int
     * @author  wxy
     * @ctime   2022/5/17 17:34
     */
    protected function getPageIndex($params, $key = 'page')
    {
        $page_index = $params[$key] ?? self::DEFAULT_PAGE_INDEX;

        return $this->isValidPageIndex($page_index) ? $page_index : self::DEFAULT_PAGE_INDEX;
    }

    /**
     * @desc    获取分页数
     * @param $params
     * @param string $key
     * @return int
     * @author  wxy
     * @ctime   2022/5/17 17:34
     */
    protected function getPageSize($params, $key = 'page_size')
    {
        $page_size = $params[$key] ?? self::DEFAULT_PAGE_SIZE;

        return $this->isValidPageSize($page_size) ? $page_size : self::DEFAULT_PAGE_SIZE;
    }

    /**
     * @desc    页码是否有效
     * @param $page_index
     * @return bool
     * @author  wxy
     * @ctime   2022/5/17 17:34
     */
    private function isValidPageIndex($page_index)
    {
        return is_integer($page_index) && $page_index > 0 ? true : false;
    }

    /**
     * @desc    分页数是否有效
     * @param $page_size
     * @return bool
     * @author  wxy
     * @ctime   2022/5/17 17:35
     */
    private function isValidPageSize($page_size)
    {
        return is_integer($page_size) && $page_size > 0 || $page_size < 1000 ? true : false;
    }
}
