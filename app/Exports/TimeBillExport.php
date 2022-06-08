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
    private $separator = '-';

    private $column = 0;

    public function __construct($data)
    {
        $this->data = $data;
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
                $event->sheet->getDelegate()->getStyle('A2:A99')->getFont()->setSize(12)->setBold(2);

                //  设置对齐
                $event->sheet->getDelegate()->getStyle('A1:A99')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:A99')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:AW1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:AW1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // 将第一行行高设置为30
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(30);

                //自动换行
                $event->sheet->getDelegate()->getStyle('C2:C99')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('D2:D99')->getAlignment()->setWrapText(true);

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
        $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(16);

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
        $cellConfig = ExcelHelper::$cellConfig;

        //  时间段
        $event->sheet->getDelegate()->getStyle('E1:G1')->applyFromArray($cellConfig['greenFontBlackGround']);
        $event->sheet->getDelegate()->getStyle('H1:K1')->applyFromArray($cellConfig['blackFontGreenGround']);
        $event->sheet->getDelegate()->getStyle('L1:L99')->applyFromArray($cellConfig['blackFontOrangeGround']);
        $event->sheet->getDelegate()->getStyle('M1:R1')->applyFromArray($cellConfig['blackFontRedGround']);
        $event->sheet->getDelegate()->getStyle('S1:S99')->applyFromArray($cellConfig['blackFontGreenGround']);
        $event->sheet->getDelegate()->getStyle('T1:U1')->applyFromArray($cellConfig['blackFontGreenGround']);
        $event->sheet->getDelegate()->getStyle('V1:Y1')->applyFromArray($cellConfig['blackFontRedGround']);
        $event->sheet->getDelegate()->getStyle('Z1:Z99')->applyFromArray($cellConfig['blackFontOrangeGround']);
        $event->sheet->getDelegate()->getStyle('AA1:AD1')->applyFromArray($cellConfig['blackFontRedGround']);

        //  统计
        $event->sheet->getDelegate()->getStyle('AN1:AN99')->applyFromArray($cellConfig['greenFontBlackGround']);
        $event->sheet->getDelegate()->getStyle('AO1:AO99')->applyFromArray($cellConfig['redFontYellowGround']);
        $event->sheet->getDelegate()->getStyle('AP1:AP99')->applyFromArray($cellConfig['blackFontRedGround']);
        $event->sheet->getDelegate()->getStyle('AQ1:AQ99')->applyFromArray($cellConfig['blackFontOrangeGround']);
        $event->sheet->getDelegate()->getStyle('AR1:AR99')->applyFromArray($cellConfig['blackFontYellowGround']);
        $event->sheet->getDelegate()->getStyle('AS1:AS99')->applyFromArray($cellConfig['blackFontBrownGround']);
        $event->sheet->getDelegate()->getStyle('AT1:AT99')->applyFromArray($cellConfig['blackFontGreenGround']);
        $event->sheet->getDelegate()->getStyle('AU1:AU99')->applyFromArray($cellConfig['blueFontGrayGround']);
        $event->sheet->getDelegate()->getStyle('AV1:AV99')->applyFromArray($cellConfig['blackFontWhiteGround']);
        $event->sheet->getDelegate()->getStyle('AW1:AW99')->applyFromArray($cellConfig['greenFontBlackGround']);

        //  周末
        foreach ($this->data as $key => $row) {
            $rowId = $key + 2;
            if ($row[0] == '日') {
                $event->sheet->getDelegate()->getStyle('A'.$rowId.':B'.$rowId)->applyFromArray($cellConfig['blackFontGreenGround']);

                //  复盘区域
                $reviewAreaStart = $rowId + 4;
                $reviewAreaEnd = $rowId + 6;
                $event->sheet->getDelegate()->getStyle('D'.$reviewAreaStart.':D'.$reviewAreaEnd)->applyFromArray($cellConfig['blackFontRedGround']);
            }
            if ($row[0] == '六') {
                $event->sheet->getDelegate()->getStyle('A'.$rowId.':B'.$rowId)->applyFromArray($cellConfig['blackFontGreenGround']);
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
