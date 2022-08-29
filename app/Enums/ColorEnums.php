<?php


namespace App\Enums;


class ColorEnums
{

    const RED = 'FF0000'; //  红色
    const ORANGE = 'FF7F00'; //  橙色
    const YELLOW = 'FFFF00'; //  黄色
    const GREEN = '00FF00'; //  绿色
    const INDIGO_BLUE = '00FFFF'; //  青色
    const BLUE = '0000FF'; //  蓝色
    const PURPLE = '8B00FF'; //  紫色
    const BROWN = '666600'; //  棕色
    const BLACK = '000000'; //  黑色
    const WHITE = 'FFFFFF'; //  黑色
    const GRAY = '666666'; //  黑色

    //  设计师推荐配色
    public static $designerRecommendConfig = [
        'workHigh' => '9ED048',  //  高效工作
        'studyHigh' => '9BC2E6',  //  高效学习

        'lifeHigh' => 'F4B084',  //  高效娱乐
        'sleepHigh' => '424c50',  //  高效睡眠

        'low' => 'BACAC6',  //  低效、拖延、杂事

        'weekend' => 'BCE672',  //  周末
        'summary' => 'F2BE45',  //  统计
    ];

    //  自定义配色  告别低效
    public static $diyConfig = [
        'workHigh' => '66CCFF',  //  高效工作
        'studyHigh' => 'FF6666',  //  高效学习

        'lifeHigh' => 'CCCC33',  //  高效娱乐
        'sleepHigh' => '333333',  //  高效睡眠

        'low' => '999999',  //  低效、拖延、杂事

        'weekend' => 'CCCC33',  //  周末
        'summary' => '66CC66',  //  统计
    ];
}
