<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TokenType extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug'
    ];

    //***** Relations *****
    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class);
    }
    public function apiServices(): BelongsToMany
    {
        return $this->belongsToMany(
            ApiService::class,
            'api_service_token_types',
            'token_type_slug',
            'api_service_id',
            'slug',
            'id'
        );
    }
}
