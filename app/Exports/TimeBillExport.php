<?php

namespace App\Exports;

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
                // 所有表头-设置字体
                $event->sheet->getDelegate()->getStyle('A1:AW1')->getFont()->setSize(12)->setBold(3);
                $event->sheet->getDelegate()->getStyle('A2:A99')->getFont()->setSize(12)->setBold(2);

                //  设置对齐
                $event->sheet->getDelegate()->getStyle('A1:A99')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:A99')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:AW1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:AW1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
//                $event->sheet->getDelegate()->getStyle('B2:B'.$this->column)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
//                //设置列宽
                // 将第一行行高设置为30
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(30);
//
//                //自动换行
                $event->sheet->getDelegate()->getStyle('C2:C99'.$this->column)->getAlignment()->setWrapText(true);

                //  设置列宽
                $this->setWidth($event);
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
}
