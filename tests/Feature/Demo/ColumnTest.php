<?php

namespace Tests\Feature\Demo;

use App\Services\BaseService;
use App\Services\MakeSample\MakeSampleOrderPaymentService;
use Tests\TestCase;

/**
 * 创建 feature 测试 php artisan make:test Demo/ColumnTest
 */
class ColumnTest extends TestCase
{
    /** @var BaseService */
    private $service;

    private $loginUser = [
        'tenant_id' => '租户ID',
        'company_code' => '企业编码',//  雪花ID，全局唯一  一个租户下可以有多家企业
        'company_name' => '企业名称',
        'user_code' => '用户编码',  //  雪花ID，全局唯一
        'user_name' => '用户名称',
    ];

    public function __construct(BaseService $service)
    {
        $this->service = $service;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testControllerName()
    {
        $response = $this->actionAName();
//        $response = $this->actionBName();

        dd($response);
    }

    /**
     * @desc    controller的一个action 对应这里的一个私有方法
     * @return mixed
     * @author  wxy
     * @ctime   2022/7/4 9:35
     */
    private function actionAName()
    {
        $params = [];
        $rules = [];
        $this->baseValidate($params, $rules);

        return $this->service->funcA($this->loginUser, $params);
    }
}
