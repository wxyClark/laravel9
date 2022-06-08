<?php


namespace App\Helpers;

class ExcelHelper
{

    /**
     * @desc    设置单元格的样式(底色、渐变,文字颜色、字体)
     * @param string $bgColor
     * @param string $fontColor
     * @return array[]
     * @author  wxy
     * @ctime   2022/6/8 13:14
     */
    public static function setCellConfig(string $bgColor, array $borders = [], string $fontColor = '000000')
    {
        return [
            'font' => [
                'name' => '楷体',
                'bold' => true,
                'italic' => false,
                'strikethrough' => false,
                'color' => [
                    'rgb' => $fontColor,
                ]
            ],
            'fill' => [
                'fillType' => 'linear', //线性填充，类似渐变
                'rotation' => 45, //渐变角度
                'startColor' => [
                    'rgb' => $bgColor, //初始颜色
                ],
                //结束颜色，如果需要单一背景色，请和初始颜色保持一致
                'endColor' => [
                    'argb' => $bgColor,
                ]
            ],
            'borders' => $borders,
//            'borders' => [
//                  'bottom' => [
//                      'borderStyle' => Border::BORDER_DASHDOT,
//                      'color' => [
//                          'rgb' => '808080'
//                     ]
//                  ],
//                  'top' => [
//                      'borderStyle' => Border::BORDER_DASHDOT,
//                      'color' => [
//                          'rgb' => '808080'
//                     ]
//                  ]
//              ],
//              'alignment' => [
//                  'horizontal' => Alignment::HORIZONTAL_CENTER,
//                  'vertical' => Alignment::VERTICAL_CENTER,
//                  'wrapText' => true,
//              ],
//            'quotePrefix'    => true
        ];
    }
}
