<?php

namespace App\Console\Commands;

use App\Helpers\DateHelpers;
use App\Jobs\SendRequestTestIntegrationDispatch;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ImportApiDataCommand extends Command
{
    protected $routes = [
//        'orders',
//        'sales',
//        'incomes',
        'stocks',
    ];
    /**
     * @var string
     * @description
     *  - dateFrom = дата формате Y-m-d или Y-m-d H:i:s. Начало получение записей по дате
     *  - limit = сколько записей покажет один запрос. Максимум может быть 500
     */
    protected $signature = 'hello {limit?}';

    /** @var string */
    protected $description = 'Импортирование данных тестового задания от компании  "Ельмикеев аналитика"';

    public function handle()
    {
        $this->comment('Начало импортирование');

        foreach ($this->routes as $route) {
            $dateFrom = $route === Stock::INTEGRATION_TEST
                ? Carbon::now()->subDay()->format('Y-m-d')
                : '2024-01-01';
            $limit =  $this->argument('limit') ?? '500';


            $startDate = Carbon::parse($dateFrom);
            $now       = Carbon::now();
            $nowYear   = $now->year;
            $givenYear = Carbon::parse($dateFrom)->year;

            if ($givenYear > $nowYear){
                throw new \RuntimeException("дата начала больше сегодняшнего года");
            }
            $dates = [];
            $diff  = $nowYear - $givenYear;
            for($i=0; $i <= $diff; $i++){
                $lastYear = $i === $diff ? true : false;
                $dates[] = [
                    'dateFrom' => $startDate->copy()->addYears($i)->format('Y-m-d'),
                    'dateTo'   => $lastYear
                        ? $now->format('Y-m-d')
                        : $startDate->copy()->endOfYear()->format('Y-m-d')
                ];
            }
            foreach ($dates as $date) {
                SendRequestTestIntegrationDispatch::dispatch($route, $date, $limit);
            }
        }

        $this->comment('конец испортирование');
    }
}
