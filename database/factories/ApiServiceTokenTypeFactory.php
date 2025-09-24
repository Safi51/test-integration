<?php

namespace Database\Factories;

use App\Models\ApiService;
use App\Models\ApiServiceTokenType;
use App\Models\TokenType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApiServiceTokenType>
 */
class ApiServiceTokenTypeFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'token_type_slug' => TokenType::first()
                ? TokenType::first()->slug
                : TokenType::factory()->create()->slug,
            'api_service_id' => ApiService::first()
                ? ApiService::first()->id
                : ApiService::factory()->create()->id,
        ];
    }
}
