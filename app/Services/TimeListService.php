<?php


namespace App\Services;

use App\Exports\TimeBillExport;
use App\Exports\TimeListExport;
use App\Helpers\DateTimeHelper;
use Maatwebsite\Excel\Facades\Excel;

/**
 * @desc    时间账单服务
 * @author  wxy
 * @ctime   2022/6/7 15:26
 * @package App\Services
 */
class TimeListService
{
    /**
     * @desc    导出时间账单(行：时段；列：日期)
     * @param int $year
     * @param int $quarter
     * @return bool
     * @author  wxy
     * @ctime   2022/6/10 10:13
     */
    public function exportTimeList(int $year, int $quarter)
    {
        $data = $this->getExportData($year, $quarter);

        $rowCount = count($data);
        $columnCount = count($data[0]);
        $newData = [];
        for ($row = 0; $row < $rowCount; $row++) {
            for ($column = 0; $column < $columnCount; $column++) {
                $newData[$column][$row+1] = $data[$row][$column];
            }
        }

        return Excel::store(new TimeListExport($newData), 'excel/'.$year.'H'.$quarter.'-timeList.xlsx', 'public');
    }

    /**
     * @desc 获取导出数据
     * @param int $year
     * @param int $quarter
     * @return array
     * @author wxy
     * @ctime 2022/8/29 16:22
     */
    private function getExportData(int $year, int $quarter)
    {
        $endMonth = $quarter * 3;
        $currentMonth = $endMonth - 2;
        $currentYear = $year;

        $currentDay = $year . '/'. $currentMonth . '/01';

        $weekNoMap = [
            '日',
            '一',
            '二',
            '三',
            '四',
            '五',
            '六',
        ];
        $weekOrderMap = [
            '',
            '目标',
            '',
            '',
            '复盘',
            '',
            '',
        ];

        $data = [];
        while ($currentMonth <= $endMonth && $year == $currentYear) {
            $weekNo = date('w', strtotime($currentDay));
            $weekOrder = date('W', strtotime($currentDay));
            $dayOrder = date('z', strtotime($currentDay));

            $targetTxt = '';
            if ($weekNo == 0) {
                $targetTxt = '目标先行';
            } elseif ($weekNo == 6) {
                $targetTxt = '周复盘';
            }

            $weekTxt = $weekOrderMap[$weekNo];
            if ($weekNo == 0) {
                $weekTxt = '第' . $weekOrder . '周 | 第' . $dayOrder . '天';
            }

            $data[] = [
                $weekNoMap[$weekNo],//  星期
                $currentDay,//  日期
                $targetTxt,
                $weekTxt,
            ];

            $timestamp = strtotime($currentDay) + DateTimeHelper::ONE_DAY;
            $currentDay = date('Y/n/d', $timestamp);
            $currentMonth = date('n', $timestamp);
            $currentYear = date('Y', $timestamp);
        }

        return $data;
    }

    /**
     * @desc    表头
     * @author  wxy
     * @ctime   2022/6/7 15:30
     */
    public function getHeader(int $wakeUpAt, int $sleepAt, $separator)
    {
        $columnsGroup = [
            //  日汇总
            $this->getSummaryColumns(),

            //  时间段
            $this->getTimeIntervalByHalfHour($wakeUpAt, $sleepAt, $separator),

            //  统计
            $this->getStatisticsColumns(),
        ];

        $header = $this->getBaseHeader($columnsGroup);
        $keys = array_keys($header);

        $offset = 0;
        foreach ($columnsGroup as $columns) {
            $columnCount = count($columns);
            $currentKeys = array_slice($keys, $offset, $columnCount);
            foreach ($currentKeys as $key => $value) {
                $header[$value] = $columns[$key];
            }

            $offset += $columnCount;
        }

        return $header;
    }

    /**
     * @desc    获取表头列
     * @return string[]
     * @author  wxy
     * @ctime   2022/6/7 16:47
     */
    private function getBaseHeader(array $columnsGroup)
    {
        $count = 0;
        foreach ($columnsGroup as $columns) {
            $count += count($columns);
        }

        $start = 'A';
        $baseHeader = [];
        for ($i = 0; $i < $count; $i++) {
            if ($i < 26) {
                //  ASCII转换
                $key = chr(ord($start) + $i);
            } else {
                //  超过26列, 从AA开始排
                $key = chr(ord($start) + floor($i / 26) - 1) . chr(ord($start) + ($i % 26));
            }

            $baseHeader[$key] = '目标先行，写下来';
        }

        return $baseHeader;
    }

    /**
     * @desc    函数描述
     * @return string[]
     * @author  wxy
     * @ctime   2022/6/7 16:55
     */
    private function getSummaryColumns()
    {
        return [
            '周',
            '日期',
            '日目标/日复盘',
            '周目标/周复盘',
        ];
    }

    /**
     * @desc    半小时一个时间段
     * @param int $wakeUpAt
     * @param int $sleepAt
     * @param string $separator
     * @return array
     * @author  wxy
     * @ctime   2022/6/7 16:20
     */
    public function getTimeIntervalByHalfHour(int $wakeUpAt, int $sleepAt, string $separator)
    {
        $array = [];
        for($i = $wakeUpAt; $i < $sleepAt; $i++) {
            $start = str_pad($i, 2, '0', STR_PAD_LEFT) . ':' . '00';
            $end = str_pad($i, 2, '0', STR_PAD_LEFT) . ':' . '30';
            $array[] = $start . $separator . $end;

            $start = str_pad($i, 2, '0', STR_PAD_LEFT) . ':' . '30';
            $end = str_pad($i + 1, 2, '0', STR_PAD_LEFT) . ':' . '00';
            $array[] = $start . $separator . $end;
        }

        $start = str_pad($wakeUpAt, 2, '0', STR_PAD_LEFT) . ':' . '00';
        $end = str_pad($sleepAt, 2, '0', STR_PAD_LEFT) . ':' . '00';
        $sleepTime = $start . $separator . $end;
        array_push($array, $sleepTime);

        return $array;
    }

    /**
     * @desc    统计列，图例
     * @return string[]
     * @author  wxy
     * @ctime   2022/6/7 16:28
     */
    public function getStatisticsColumns()
    {
        return [
            '金币'."\r\n".'总计',

            '高效'."\r\n".'工作',

            '自我'."\r\n".'提升',

            '高效'."\r\n".'娱乐',

            '杂'."\r\n".'事',

            '睡'."\r\n".'觉',
        ];
    }

}
