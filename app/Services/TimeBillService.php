<?php


namespace App\Services;

/**
 * @desc    时间账单服务
 * @author  wxy
 * @ctime   2022/6/7 15:26
 * @package App\Services
 */
class TimeBillService
{
    /**
     * @desc    导出时间账单
     * @param int $year
     * @param int $quarter
     * @param int $wakeUpAt
     * @param int $sleepAt
     * @param string $separator
     * @return \string[][]
     * @author  wxy
     * @ctime   2022/6/7 17:10
     */
    public function exportTimeBill(int $year, int $quarter, int $wakeUpAt, int $sleepAt, string $separator = '—')
    {
        $header = $this->getHeader($wakeUpAt, $sleepAt, $separator);

        return [$header];
    }

    /**
     * @desc    表头
     * @author  wxy
     * @ctime   2022/6/7 15:30
     */
    private function getHeader(int $wakeUpAt, int $sleepAt, $separator)
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
                $key = chr(ord($start) + ceil($i / 26) - 1) . chr(ord($start) + ceil($i % 26));
            }

            $baseHeader[$key] = '';
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
            '星期',
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
    private function getTimeIntervalByHalfHour(int $wakeUpAt, int $sleepAt, string $separator)
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
        array_unshift($array, $sleepTime);
        array_push($array, $sleepTime);

        return $array;
    }

    /**
     * @desc    统计列，图例
     * @return string[]
     * @author  wxy
     * @ctime   2022/6/7 16:28
     */
    private function getStatisticsColumns()
    {
        return [
            '金币'."\r\n".'总计',   //  红色字+黄色底
            '高效'."\r\n".'工作',   //  红色
            '强迫'."\r\n".'工作',   //  橙色
            '自我'."\r\n".'提升',   //  黄色
            '尽兴'."\r\n".'娱乐',   //  蓝色
            '陪'."\r\n".'伴',      //  绿色
            '杂'."\r\n".'事',      //  灰色
            '无效'."\r\n".'拖延',   //  白色
            '睡觉'."\r\n".'回血',   //  黑色
        ];
    }

    /**
     * @desc    第一列(日期)
     * @author  wxy
     * @ctime   2022/6/7 15:30
     */
    private function getFirstColumn()
    {

    }
}
