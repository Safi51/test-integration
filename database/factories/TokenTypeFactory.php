<?php

namespace Database\Factories;

use App\Models\TokenType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TokenType>
 */
class TokenTypeFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'slug' => TokenType::first() ? TokenType::first() : 'Bearer',
        ];
    }
}
