<?php


namespace App\Enums;

/**
 * @desc    审核流常量模板
 * @author  wxy
 * @ctime   2022/7/18 16:32
 * @package App\Enums
 */
class ProcessOrderDemoEnums
{
    //  单据状态
    const STATUS_DEFAULT = 0;
    const STATUS_NEED_DO_STH = 1;
    const STATUS_NEED_FILL_STH = 2;
    const STATUS_NEED_CONFIRM_STH = 3;
    const STATUS_NEED_CHECK_STH = 4;
    const STATUS_REJECTED = 5;
    const STATUS_CHECKED = 6;
    const STATUS_CANCELED = 7;

    public static $statusMap = [
        self::STATUS_DEFAULT => '非法数据',
        self::STATUS_NEED_DO_STH => '待处理XX',
        self::STATUS_NEED_FILL_STH => '待填写YY',
        self::STATUS_NEED_CONFIRM_STH => '待确认',
        self::STATUS_NEED_CHECK_STH => '待审核',
        self::STATUS_REJECTED => '驳回',
        self::STATUS_CHECKED => '已审核',
        self::STATUS_CANCELED => '已取消',
    ];

    //  有效状态
    public static $validStatusArray = [
        self::STATUS_NEED_DO_STH,
        self::STATUS_NEED_FILL_STH,
        self::STATUS_NEED_CONFIRM_STH,
        self::STATUS_NEED_CHECK_STH,
        self::STATUS_REJECTED,
        self::STATUS_CHECKED,
    ];

    //  可取消的状态
    public static $canCancelStatusArray = [
        self::STATUS_NEED_DO_STH,
        self::STATUS_NEED_FILL_STH,
        self::STATUS_NEED_CONFIRM_STH,
        self::STATUS_NEED_CHECK_STH,
        self::STATUS_REJECTED,
    ];



    //  操作类型
    const ACTION_TYPE_ADD = 1;
    const ACTION_TYPE_EDIT = 2;
    const ACTION_TYPE_FILL_STH = 3;
    const ACTION_TYPE_CONFIRM_STH = 4;
    const ACTION_TYPE_CHECK = 5;
    const ACTION_TYPE_REJECT = 6;
    const ACTION_TYPE_CANCEL = 7;
    const ACTION_TYPE_REDO = 8;
    const ACTION_TYPE_SYNC = 9;

    public static $actionMap = [
        self::ACTION_TYPE_ADD => '新增',
        self::ACTION_TYPE_EDIT => '编辑',
        self::ACTION_TYPE_FILL_STH => '填写信息',
        self::ACTION_TYPE_CONFIRM_STH => '确认信息',
        self::ACTION_TYPE_CHECK => '审核通过',
        self::ACTION_TYPE_REJECT => '审核驳回',
        self::ACTION_TYPE_CANCEL => '取消',
        self::ACTION_TYPE_REDO => '重做',
        self::ACTION_TYPE_SYNC => '数据同步',
    ];

    public static $actionRemarkMap = [
        self::ACTION_TYPE_ADD => '新增xx单',
        self::ACTION_TYPE_EDIT => '编辑xx单',
        self::ACTION_TYPE_FILL_STH => '填写信息',
        self::ACTION_TYPE_CONFIRM_STH => '确认信息',
        self::ACTION_TYPE_CHECK => 'xx审核-审核通过',
        self::ACTION_TYPE_REJECT => 'xx审核-审核驳回',
        self::ACTION_TYPE_CANCEL => '取消',
        self::ACTION_TYPE_REDO => '重做',
        self::ACTION_TYPE_SYNC => 'xx触发数据同步',
    ];
}
