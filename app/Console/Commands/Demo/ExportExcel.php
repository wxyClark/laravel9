<?php

namespace App\Console\Commands\Demo;

use App\Helpers\ArrayHelper;
use App\Services\Base\Export;
use App\Services\TimeBillService;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Demo:ExportExcel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '导出Excel';

    private $service;

    public function __construct(TimeBillService $service)
    {
        parent::__construct();
        $this->service = $service;
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start = microtime(true);

        try {
//            $this->exportAsArray();

            $data = $this->service->exportTimeBill(2022, 3, 6, 23, '—');

            Excel::store(new Export([], $data), 'excel/2022H3-timeBill.xlsx', 'public');

        } catch (\Exception $e) {
            $logData = ArrayHelper::makeLogData($e, $this->description);
            \Log::error(ArrayHelper::logArrayToString($logData));
            $this->error($e->getMessage());
        }

        $exec = microtime(true) - $start;
        $this->info('exec = ' . $exec);

        return true;
    }

    private function exportAsArray()
    {
        $export_result = [
            ['id' => 1, 'name' => '张三', 'age' => 18],
            ['id' => 2, 'name' => '李四', 'age' => 20],
            ['id' => 3, 'name' => '王五', 'age' => 22],
        ];
        $header = array_keys($export_result[0]);
        array_unshift($export_result, $header);

        $this->info('导出成功');

        Excel::store(new Export([], $export_result), 'excel/test2.xlsx', 'public');
    }

}
