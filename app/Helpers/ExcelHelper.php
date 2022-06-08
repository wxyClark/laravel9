<?php


namespace App\Helpers;


use App\Enums\ColorEnum;

class ExcelHelper
{
    /**
     * @desc    单元格样式，底色
     * @return \array[][]
     * @author  wxy
     * @ctime   2022/6/8 9:56
     */
    public static $cellConfig = [
        'redFontYellowGround' => [
            'font' => [
                'name' => '楷体',
                'bold' => true,
                'italic' => false,
                'strikethrough' => false,
                'color' => [
                    'rgb' => ColorEnum::RED,
                ]
            ],
            'fill' => [
                'fillType' => 'linear', //线性填充，类似渐变
                'rotation' => 45, //渐变角度
                'startColor' => [
                    'rgb' => ColorEnum::YELLOW, //初始颜色
                ],
                //结束颜色，如果需要单一背景色，请和初始颜色保持一致
                'endColor' => [
                    'argb' => ColorEnum::YELLOW,
                ]
            ]
        ],
        'redFontBlackGround' => [
            'font' => [
                'name' => '楷体',
                'bold' => true,
                'italic' => false,
                'strikethrough' => false,
                'color' => [
                    'rgb' => ColorEnum::RED,
                ]
            ],
            'fill' => [
                'fillType' => 'linear', //线性填充，类似渐变
                'rotation' => 45, //渐变角度
                'startColor' => [
                    'rgb' => ColorEnum::BLACK, //初始颜色
                ],
                //结束颜色，如果需要单一背景色，请和初始颜色保持一致
                'endColor' => [
                    'argb' => ColorEnum::BLACK,
                ]
            ]
        ],
        'blackFontGreenGround' => [
            'font' => [
                'name' => '楷体',
                'bold' => true,
                'italic' => false,
                'strikethrough' => false,
                'color' => [
                    'rgb' => ColorEnum::BLACK,
                ]
            ],
            'fill' => [
                'fillType' => 'linear', //线性填充，类似渐变
                'rotation' => 45, //渐变角度
                'startColor' => [
                    'rgb' => ColorEnum::GREEN, //初始颜色
                ],
                //结束颜色，如果需要单一背景色，请和初始颜色保持一致
                'endColor' => [
                    'argb' => ColorEnum::GREEN,
                ]
            ]
        ],
        'greenFontBlackGround' => [
            'font' => [
                'name' => '楷体',
                'bold' => true,
                'italic' => false,
                'strikethrough' => false,
                'color' => [
                    'rgb' => ColorEnum::GREEN,
                ]
            ],
            'fill' => [
                'fillType' => 'linear', //线性填充，类似渐变
                'rotation' => 45, //渐变角度
                'startColor' => [
                    'rgb' => ColorEnum::BLACK, //初始颜色
                ],
                //结束颜色，如果需要单一背景色，请和初始颜色保持一致
                'endColor' => [
                    'argb' => ColorEnum::BLACK,
                ]
            ]
        ],
        'blackFontRedGround' => [
            'font' => [
                'name' => '楷体',
                'bold' => true,
                'italic' => false,
                'strikethrough' => false,
                'color' => [
                    'rgb' => ColorEnum::BLACK,
                ]
            ],
            'fill' => [
                'fillType' => 'linear', //线性填充，类似渐变
                'rotation' => 45, //渐变角度
                'startColor' => [
                    'rgb' => ColorEnum::RED, //初始颜色
                ],
                //结束颜色，如果需要单一背景色，请和初始颜色保持一致
                'endColor' => [
                    'argb' => ColorEnum::RED,
                ]
            ]
        ],
        'blackFontOrangeGround' => [
            'font' => [
                'name' => '楷体',
                'bold' => true,
                'italic' => false,
                'strikethrough' => false,
                'color' => [
                    'rgb' => ColorEnum::BLACK,
                ]
            ],
            'fill' => [
                'fillType' => 'linear', //线性填充，类似渐变
                'rotation' => 45, //渐变角度
                'startColor' => [
                    'rgb' => ColorEnum::ORANGE, //初始颜色
                ],
                //结束颜色，如果需要单一背景色，请和初始颜色保持一致
                'endColor' => [
                    'argb' => ColorEnum::ORANGE,
                ]
            ]
        ],
        'blackFontYellowGround' => [
            'font' => [
                'name' => '楷体',
                'bold' => true,
                'italic' => false,
                'strikethrough' => false,
                'color' => [
                    'rgb' => ColorEnum::BLACK,
                ]
            ],
            'fill' => [
                'fillType' => 'linear', //线性填充，类似渐变
                'rotation' => 45, //渐变角度
                'startColor' => [
                    'rgb' => ColorEnum::YELLOW, //初始颜色
                ],
                //结束颜色，如果需要单一背景色，请和初始颜色保持一致
                'endColor' => [
                    'argb' => ColorEnum::YELLOW,
                ]
            ]
        ],
        'blackFontBrownGround' => [
            'font' => [
                'name' => '楷体',
                'bold' => true,
                'italic' => false,
                'strikethrough' => false,
                'color' => [
                    'rgb' => ColorEnum::BLACK,
                ]
            ],
            'fill' => [
                'fillType' => 'linear', //线性填充，类似渐变
                'rotation' => 45, //渐变角度
                'startColor' => [
                    'rgb' => ColorEnum::BROWN, //初始颜色
                ],
                //结束颜色，如果需要单一背景色，请和初始颜色保持一致
                'endColor' => [
                    'argb' => ColorEnum::BROWN,
                ]
            ]
        ],
        'blackFontGrayGround' => [
            'font' => [
                'name' => '楷体',
                'bold' => true,
                'italic' => false,
                'strikethrough' => false,
                'color' => [
                    'rgb' => ColorEnum::GRAY,
                ]
            ],
            'fill' => [
                'fillType' => 'linear', //线性填充，类似渐变
                'rotation' => 45, //渐变角度
                'startColor' => [
                    'rgb' => ColorEnum::GRAY, //初始颜色
                ],
                //结束颜色，如果需要单一背景色，请和初始颜色保持一致
                'endColor' => [
                    'argb' => ColorEnum::GRAY,
                ]
            ]
        ],
        'blackFontWhiteGround' => [
            'font' => [
                'name' => '楷体',
                'bold' => true,
                'italic' => false,
                'strikethrough' => false,
                'color' => [
                    'rgb' => ColorEnum::GRAY,
                ]
            ],
            'fill' => [
                'fillType' => 'linear', //线性填充，类似渐变
                'rotation' => 45, //渐变角度
                'startColor' => [
                    'rgb' => ColorEnum::WHITE, //初始颜色
                ],
                //结束颜色，如果需要单一背景色，请和初始颜色保持一致
                'endColor' => [
                    'argb' => ColorEnum::WHITE,
                ]
            ]
        ],
        'blueFontGrayGround' => [
            'font' => [
                'name' => '楷体',
                'bold' => true,
                'italic' => false,
                'strikethrough' => false,
                'color' => [
                    'rgb' => ColorEnum::BLUE,
                ]
            ],
            'fill' => [
                'fillType' => 'linear', //线性填充，类似渐变
                'rotation' => 45, //渐变角度
                'startColor' => [
                    'rgb' => ColorEnum::GRAY, //初始颜色
                ],
                //结束颜色，如果需要单一背景色，请和初始颜色保持一致
                'endColor' => [
                    'argb' => ColorEnum::GRAY,
                ]
            ]
        ],
    ];
}
