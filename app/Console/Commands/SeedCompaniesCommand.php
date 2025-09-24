<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\ApiService;
use App\Models\ApiServiceTokenType;
use App\Models\Company;
use App\Models\Token;
use App\Models\TokenType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SeedCompaniesCommand extends Command
{
    /** @var string */
    protected $signature = 'db:seed';

    /** @var string */
    protected $description = 'Засевание данных для компании';

    public function handle()
    {
        DB::beginTransaction();

        $this->comment('Начало засевание данных компании');

        $this->line('  • Создание компании');
        $company = Company::factory()->create();

        $this->line('  • Создание аккаунтов компании');
        $firstAccount = Account::factory()->create(['company_id' => $company->id]);

        $this->line('  • Создание типа токена');
        $tokenType =  TokenType::factory()->create();

        $this->line('  • Создание апи сервиса');
        $apiService = ApiService::factory()->create([
            'name' => 'test'
        ]);

        $this->line('  • Создание токена для первого аккаунта');
        $firstAccountToken = Token::factory()->create([
            'account_id'      => $firstAccount->id,
            'api_service_id'  => $apiService->id,
            'type_slug'       => $tokenType->slug,
        ]);
        $firstToken = $firstAccountToken->createToken('API Token')->plainTextToken;
        $firstAccountToken->token = $firstToken;
        $firstAccountToken->save();

        $this->line('  • Создание belongsToMany тип токена и создание токена');
        ApiServiceTokenType::factory()->create();

        $this->comment('Конец засевание данных компании');

        DB::commit();
    }
}
