<?php

namespace App\Jobs;

use App\Helpers\TestIntegration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendRequestTestIntegrationDispatch implements ShouldQueue
{
    use Queueable;

    protected string $url;
    protected string $route;
    protected array $date;
    protected string $limit;
    protected string $model;
    protected int $accountId;

    public function __construct(string $route, array $date, string $limit, int $accountId)
    {
        $this->url = 'http://' . config('services.integration.test') . ':6969/api/';
        $this->route = $route;
        $this->date = $date;
        $this->limit = $limit;
        $this->accountId = $accountId;
    }

    public function handle(): void
    {
        $page = 1;
        $lastPage = 2;
        do{
            Log::info('  • получение данных обновление либо сохранение ' . $this->route . ' страницы: ' . $page);
            $res = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->get($this->url . $this->route, [
                'key'      => config('services.verification.key'),
                'dateFrom' => $this->date['dateFrom'],
                'dateTo'   => $this->date['dateTo'],
                'limit'    => $this->limit,
                'page'     => $page,
            ]);

            if ($res->status() === 429){
                Log::info('Ошибка 429: Too many requests. Код уходить  спать на 7 сек');
                $retryAfter = $res->header('Retry-After', 7);

                sleep($retryAfter);
                continue;
            }
            if (!$res->successful()){
                Log::channel('failed_integration')
                    ->info('Ошибка при тестовой интеграции orders на странице: ' . $page,
                        $res->json() ?? []);
                break;
            }
            $res = $res->json();

            $uniques = TestIntegration::getUnique($this->route);
            $class = TestIntegration::getClass($this->route);

            foreach ($res['data'] as $item) {
                $data = array_merge($item, ['account_id' => $this->accountId]);
                $uniqueData = [];
                foreach ($uniques as $unique) {
                   $uniqueData[$unique] = $data[$unique] ?? null;
                }

                $uniqueData['account_id'] = $this->accountId;
                Log::info($uniqueData);
                $class::updateOrCreate($uniqueData, $data);
            }
            $lastPage = $res['meta']['last_page'];
            $page++;
        }while ($page <= $lastPage);

        Log::info('конец эскпортирование ' . $this->route);
    }
}
