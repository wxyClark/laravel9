<?php

namespace App\Services;

use App\Helpers\ArrayHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BaseService
{
    const ERROR_CODE_SUCCESS = 0;

    const ERROR_CODE_PARAMS_VALID = 10001;
    const ERROR_CODE_RECORD_NOT_EXIST = 10002;
    const ERROR_CODE_RECORD_HAS_EXIST = 10003;

    const ERROR_CODE_BUSINESS_IMPASSABLE = 20001;

    const ERROR_CODE_INNER_REQUEST_ERROR = 30001;

    const ERROR_CODE_UNKNOWN = 50000;

    //  错误码
    public static $errorCodeMap = [
        self::ERROR_CODE_SUCCESS => '成功',

        self::ERROR_CODE_PARAMS_VALID => '入参校验不通过',
        self::ERROR_CODE_RECORD_NOT_EXIST => '指定记录不存在',
        self::ERROR_CODE_RECORD_HAS_EXIST => '指定记录已存在，不支持重复创建',

        self::ERROR_CODE_BUSINESS_IMPASSABLE => '业务流程不支持',

        self::ERROR_CODE_INNER_REQUEST_ERROR => '内部调用异常',

        self::ERROR_CODE_UNKNOWN => '未知错误',
    ];

    //  需要记录日志的错误码
    public static $needLogCods = [
        self::ERROR_CODE_UNKNOWN,
    ];

    /**
     * @desc    记录日志-入参
     * @author  wxy
     * @ctime   2022/7/18 11:20
     */
    public static  function logParams()
    {
        $logData = func_get_args();
        Log::info(__CLASS__.'@'.__FUNCTION__.'入参:', ArrayHelper::logArrayToString($logData));
    }


    /**
     * @desc    记录日志-异常
     * @param \Throwable $throwable
     * @param string $title
     * @author  wxy
     * @ctime   2022/7/18 12:03
     */
    public static function logThrowable(\Throwable $throwable, string $title)
    {
        $logData = ArrayHelper::makeLogData($throwable, $title);
        Log::error(__CLASS__.'异常', ArrayHelper::logArrayToString($logData));
    }

    /**
     * @desc    记录日志-结果
     * @author  wxy
     * @ctime   2022/7/18 11:20
     */
    protected function logResult()
    {

    }

    /**
     * @desc    service 外部方法模板
     * @author  wxy
     * @ctime   2022/7/18 11:58
     */
    final function publicDemo(int $tenant_id, array $params)
    {
        $title = '业务名称';

        //  读数据
        try {

            //  调用方法获取数据

        } catch (\Exception $e) {
            if ($e->getCode() !== BaseService::CODE) {
                self::logThrowable($e, $title . ' 读异常');
            }

            throw new \Exception($e->getMessage(), $e->getCode());
        }

        //  写数据
        try {
            DB::beginTransaction();

            //  业务逻辑

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            if ($e->getCode() !== BaseService::CODE) {
                self::logThrowable($e, $title . ' 写异常');
            }

            throw new \Exception($e->getMessage() . ' 处理失败：',$e->getMessage(), $e->getCode());
        }

        return [
            'status' => true,
            'notice' => '提示文案',
            'data' => [],
        ];
    }

    /**
     * @desc    service 内部方法模板
     * @param int $tenant_id
     * @param array $params
     * @return array
     * @author  wxy
     * @ctime   2022/7/18 12:07
     */
    final function privateDemo(int $tenant_id, array $params)
    {
        $data = [];

        //  参数转换

        //  数据获取

        //  数据组装

        return $data;
    }
}
