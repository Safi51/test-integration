<?php

namespace App\Console\Commands;

use App\Jobs\SendRequestTestIntegrationDispatch;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ImportApiDataCommand extends Command
{
    protected $routes = [
        'orders',
        'sales',
        'incomes',
        'stocks',
    ];
    /**
     * @var string
     * @description
     *  - limit = сколько записей покажет один запрос. Максимум может быть 500
     */
//    protected $signature = 'test:integration {limit?}';
    protected $signature = 'hello {limit?}';

    /** @var string */
    protected $description = 'Импортирование данных тестового задания от компании  "Ельмикеев аналитика"';

    public function handle()
    {
        $this->comment('Начало импортирование');
        foreach ($this->routes as $route) {
            $this->info("Обрабатывается маршрут: {$route}");
            $dateFrom = $route === Stock::INTEGRATION_TEST
                ? Carbon::now()->subDay()->format('Y-m-d')
                : '2024-01-01';
               $limit =  $this->argument('limit') ?? '500';

            $this->line("  • Дата начала: {$dateFrom}, лимит: {$limit}");

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
                $this->line('  • Отправка в очередь для получение данных');
                SendRequestTestIntegrationDispatch::dispatch($route, $date, $limit);
            }
        }

        $this->comment('конец испортирование');
    }
}
