<?php

namespace App\Console\Commands;

use App\Jobs\SendRequestTestIntegrationDispatch;
use App\Models\Account;
use App\Models\ApiService;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
     *  - dateFrom дата если нету то ставить сегодняшней даты -1 день
     */
    protected $signature = 'test:integration {limit?}';

    /** @var string */
    protected $description = 'Импортирование данных тестового задания от компании  "Ельмикеев аналитика"';

    public function handle()
    {
        Log::info('Начало импортирование');
        $apiService = ApiService::with([
            'tokenSlugs'
        ])->whereName('test')->first();

        $availableTokenTypes = $apiService->tokenSlugs->pluck('slug')->toArray();

        if (!$apiService) {
            Log::info('не нашел апиСервис! Добавьте в бд через adminer либо добавьте
            через команду php artisan db:seed');
            return;
        }

        $accounts = Account::with([
            'tokens'
        ])->get();
        foreach ($accounts as $account){
            $token = $account->tokens->filter(function ($token) use ($apiService, $availableTokenTypes) {
                return $token->api_service_id === $apiService->id
                    || in_array($token->type_slug, $availableTokenTypes);
            })->first();

            if (!$token) {
                Log::info('не нашел токен для верификации');
                return;
            }

            foreach ($this->routes as $route) {
                Log::info("Обрабатывается маршрут: {$route}");
                $dateFrom = $this->argument('dateFrom') !== null || $route !== Stock::INTEGRATION_TEST
                    ? Carbon::parse($this->argument('dateFrom'))->format('Y-m-d')
                    : Carbon::now()->subDay()->format('Y-m-d');

                $limit =  $this->argument('limit') ?? '500';

                Log::info("  • Дата начала: {$dateFrom}, лимит: {$limit}");

                $startDate = Carbon::parse($dateFrom);
                $now       = Carbon::now();
                $nowYear   = $now->year;
                $givenYear = Carbon::parse($dateFrom)->year;

                if ($givenYear > $nowYear){
                    Log::error('При обновление данных дата начала больше сегодняшнего года');
                    throw new \RuntimeException("дата начала больше сегодняшнего года");
                }

                $dates = [];
                $diff  = $nowYear - $givenYear;
                for($i = 0; $i <= $diff; $i++){
                    $lastYear = $i === $diff;
                    $dates[] = [
                        'dateFrom' => $startDate->copy()->addYears($i)->format('Y-m-d'),
                        'dateTo'   => $lastYear
                            ? $now->format('Y-m-d')
                            : $startDate->copy()->endOfYear()->format('Y-m-d')
                    ];
                }

                foreach ($dates as $date) {
                    Log::info('  • Отправка в очередь для получение данных');
                    SendRequestTestIntegrationDispatch::dispatch($route, $date, $limit, $account->id);
                }
            }
        }
    }
}
