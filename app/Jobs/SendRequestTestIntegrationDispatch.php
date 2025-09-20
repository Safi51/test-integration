<?php

namespace App\Jobs;

use App\Helpers\TestIntegration;
use App\Models\Income;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Stock;
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
//    protected $model;

    public function __construct(string $route, array $date, string $limit)
    {
        $this->url = 'http://' . config('services.integration.test') . ':6969/api/';
        $this->route = $route;
        $this->date = $date;
        $this->limit = $limit;
//        $this->model = TestIntegration::getModel($route);
    }

    public function handle(): void
    {
        Log::info('s', [$this->url, $this->route, $this->date, $this->limit]);
        $page = 1;
        $lastPage = 2;
        do{
            $res = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->get($this->url . $this->route, [
                'key'      => config('services.verification.key'),
                'dateFrom' => $this->date['dateFrom'],
                'dateTo'   => $this->date['dateTo'],
                'limit'    => $this->limit,
                'page'     => $page,
            ]);
            Log::info($res->body());
            Log::info($res->status());
            if ($res->status() === 429){
                Log::info('wtf');
                $retryAfter = $res->header('Retry-After', 7);

                sleep($retryAfter);
                continue;
            }
            if (!$res->successful()){
                Log::channel('failed_integration')
                    ->info('Ошибка при тестовой интеграции orders на странице: ' . $page, $res->json() ?? []);
                break;
            }
            $res = $res->json();
            switch ($this->route){
                case Order::INTEGRATION_TEST:
                    Order::insert($res['data']);
                    break;
                case Sale::INTEGRATION_TEST:
                    Sale::insert($res['data']);
                    break;
                case Income::INTEGRATION_TEST:
                    Income::insert($res['data']);
                    break;
                case Stock::INTEGRATION_TEST:
                    Stock::insert($res['data']);
                    break;
            }

            $lastPage = $res['meta']['last_page'];
            $page++;
        }while ($page <= $lastPage);
    }
}
