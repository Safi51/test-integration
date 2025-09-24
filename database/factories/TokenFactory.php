<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\ApiService;
use App\Models\TokenType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Token>
 */
class TokenFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'account_id'     => Account::first()
                ? Account::first()->id
                : Account::factory()->create()->id,
            'api_service_id' => ApiService::first()
                ? ApiService::first()->id
                : ApiService::factory()->create()->id,
            'type_slug'      => TokenType::first()
                ? TokenType::first()->slug
                : TokenType::factory()->create()->slug,
            'expires_at'     => Carbon::now()->addDays(30),
        ];
    }
}
