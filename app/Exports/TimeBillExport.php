<?php

namespace App\Exports;

use App\Enums\ColorEnum;
use App\Helpers\ExcelHelper;
use App\Services\TimeBillService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\DefaultValueBinder;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TimeBillExport extends DefaultValueBinder implements FromCollection, WithCustomValueBinder, WithHeadings, WithEvents
{
    private $data;
    private $wakeUpAt = 6;
    private $sleepAt = 23;
    private $separator = '——';

    private $column = 0;
    private $maxRowId = 0;

    public function __construct($data)
    {
        $this->data = $data;
        $this->maxRowId = count($data) + 1; //  表头占1行
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $this->column = count($this->data) + 1;
        return collect($this->data);
    }

    public function bindValue(\PhpOffice\PhpSpreadsheet\Cell\Cell $cell, $value)
    {
        // Excel默认支持15位的数字，超过15位就会将其转换成0标记为无效位
        if (preg_match('/^[\+\-]?(\d+\\.?\d*|\d*\\.?\d+)([Ee][\-\+]?[0-2]?\d{1,3})?$/', $value) &&
            strlen($value) > 10
        ) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }
        return parent::bindValue($cell, $value);
    }

    /**
     * 定义表单头
     * @return array
     */
    public function headings(): array
    {
        return app(TimeBillService::class)->getHeader($this->wakeUpAt, $this->sleepAt, $this->separator);
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                // 冻结
                $event->sheet->freezePaneByColumnAndRow('5','2');

                // 所有表头-设置字体
                $event->sheet->getDelegate()->getStyle('A1:AW1')->getFont()->setSize(12)->setBold(3);
                $event->sheet->getDelegate()->getStyle('A2:A' . $this->maxRowId)->getFont()->setSize(12)->setBold(2);

                //  设置对齐
                $event->sheet->getDelegate()->getStyle('A1:A' . $this->maxRowId)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:A' . $this->maxRowId)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:AW1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:AW1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // 将第一行行高设置为30
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(30);

                //自动换行
                $event->sheet->getDelegate()->getStyle('C2:C' . $this->maxRowId)->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('D2:D' . $this->maxRowId)->getAlignment()->setWrapText(true);

                //  设置列宽
                $this->setWidth($event);

                //  设置颜色
                $this->setColor($event);
            },
        ];
    }

    //  设置列宽
    private function setWidth($event)
    {
        $header = $this->headings();

        //设置列宽—— 列头
        $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(5);
        $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(10);
        $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(16);
        $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20);

        //设置列宽—— 时段
        $keys = array_keys($header);
        $timeColumns = app(TimeBillService::class)->getTimeIntervalByHalfHour($this->wakeUpAt, $this->sleepAt, $this->separator);
        $timeColumnCount = count($timeColumns);
        $columnKeys = array_slice($keys, 4, $timeColumnCount);
        foreach ($columnKeys as $columnKey) {
            $event->sheet->getDelegate()->getColumnDimension((string)$columnKey)->setWidth(25);
        }

        //设置列宽—— 统计
        $statisticsColumns = app(TimeBillService::class)->getStatisticsColumns($this->wakeUpAt, $this->sleepAt, $this->separator);
        $columnKeys = array_slice($keys, 4 + $timeColumnCount, count($statisticsColumns));
        foreach ($columnKeys as $columnKey) {
            $event->sheet->getDelegate()->getColumnDimension((string)$columnKey)->setWidth(10);
        }
    }

    //  设置颜色
    private function setColor($event)
    {

        $config = [
            'workHigh' => ExcelHelper::setCellConfig('A9D08E'),  //  高效工作
            'workLow' => ExcelHelper::setCellConfig('c6e0b4'),  //  强迫工作

            'studyHigh' => ExcelHelper::setCellConfig('9bc2e6'),  //  高效学习
            'studyLow' => ExcelHelper::setCellConfig('b4c6e7'),  //  低效学习

            'lifeHigh' => ExcelHelper::setCellConfig('f4b084'),  //  高效娱乐
            'lifeLow' => ExcelHelper::setCellConfig('f8cbad'),  //  底效消遣

            'sleepHigh' => ExcelHelper::setCellConfig('f2ddfe'),  //  高效睡眠
            'sleepLow' => ExcelHelper::setCellConfig('bfa5fa'),  //  低效拖延

            'weekend' => ExcelHelper::setCellConfig('CCFFCC'),  //  周末
            'summary' => ExcelHelper::setCellConfig('33CCCC'),  //  统计
        ];

        //  时间段
        $event->sheet->getDelegate()->getStyle('E1:G' . $this->maxRowId)->applyFromArray($config['sleepHigh']);

        $event->sheet->getDelegate()->getStyle('H1:J' . $this->maxRowId)->applyFromArray($config['lifeLow']);
        $event->sheet->getDelegate()->getStyle('K1:K' . $this->maxRowId)->applyFromArray($config['studyLow']);
        $event->sheet->getDelegate()->getStyle('L1:L' . $this->maxRowId)->applyFromArray($config['workLow']);
        $event->sheet->getDelegate()->getStyle('M1:R' . $this->maxRowId)->applyFromArray($config['workHigh']);
        $event->sheet->getDelegate()->getStyle('S1:S' . $this->maxRowId)->applyFromArray($config['lifeLow']);
        $event->sheet->getDelegate()->getStyle('T1:U' . $this->maxRowId)->applyFromArray($config['sleepHigh']);
        $event->sheet->getDelegate()->getStyle('V1:Y' . $this->maxRowId)->applyFromArray($config['workHigh']);
        $event->sheet->getDelegate()->getStyle('Z1:Z' . $this->maxRowId)->applyFromArray($config['workLow']);
        $event->sheet->getDelegate()->getStyle('AA1:AD' . $this->maxRowId)->applyFromArray($config['workHigh']);
        $event->sheet->getDelegate()->getStyle('AE1:AG' . $this->maxRowId)->applyFromArray($config['studyLow']);
        $event->sheet->getDelegate()->getStyle('AH1:AM' . $this->maxRowId)->applyFromArray($config['lifeLow']);

        $event->sheet->getDelegate()->getStyle('AN1:AN' . $this->maxRowId)->applyFromArray($config['sleepHigh']);

        //  统计
        $event->sheet->getDelegate()->getStyle('AO1:AO' . $this->maxRowId)->applyFromArray($config['summary']); //  金币总计

        $event->sheet->getDelegate()->getStyle('AP1:AP' . $this->maxRowId)->applyFromArray($config['workHigh']); //  高效工作
        $event->sheet->getDelegate()->getStyle('AQ1:AQ' . $this->maxRowId)->applyFromArray($config['workLow']); //  强迫工作
        $event->sheet->getDelegate()->getStyle('AR1:AR' . $this->maxRowId)->applyFromArray($config['studyLow']); //  自我提升
        $event->sheet->getDelegate()->getStyle('AS1:AS' . $this->maxRowId)->applyFromArray($config['sleepLow']); //  无效拖延
        $event->sheet->getDelegate()->getStyle('AT1:AT' . $this->maxRowId)->applyFromArray($config['lifeLow']); //  陪伴
        $event->sheet->getDelegate()->getStyle('AU1:AU' . $this->maxRowId)->applyFromArray($config['lifeHigh']); //  娱乐
        $event->sheet->getDelegate()->getStyle('AV1:AV' . $this->maxRowId)->applyFromArray($config['lifeLow']); //  杂事
        $event->sheet->getDelegate()->getStyle('AW1:AW' . $this->maxRowId)->applyFromArray($config['sleepHigh']); //  睡觉

        //  周末
        foreach ($this->data as $key => $row) {
            $rowId = $key + 2;  //  周日的key 0,首行占1行
            if ($row[0] == '日') {
                $event->sheet->getDelegate()->getStyle('A'.$rowId.':B'.$rowId)->applyFromArray($config['weekend']);
                $event->sheet->getDelegate()->getStyle('H'.$rowId.':AM'.$rowId)->applyFromArray($config['weekend']);

                //  复盘区域
                $reviewAreaStart = $rowId + 4;
                $reviewAreaEnd = $rowId + 6;
                $event->sheet->getDelegate()->getStyle('D'.$reviewAreaStart.':D'.$reviewAreaEnd)->applyFromArray($config['workHigh']);
            }
            if ($row[0] == '六') {
                $event->sheet->getDelegate()->getStyle('A'.$rowId.':B'.$rowId)->applyFromArray($config['weekend']);
                $event->sheet->getDelegate()->getStyle('H'.$rowId.':AM'.$rowId)->applyFromArray($config['weekend']);
            }
        }
    }

    //  设置边框
    private function setBolder($event)
    {

    }

    //  合并单元格
    private function mergeCells($event)
    {

    }

}
