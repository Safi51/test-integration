<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiServiceTokenType extends Model
{
    use HasFactory;

    protected $fillable = [
        'token_type_slug',
        'api_service_id'
    ];

    //***** Relations *****
    public function tokenType(): BelongsTo
    {
        return $this->belongsTo(TokenType::class, 'slug', 'token_type_slug');
    }
    public function apiService(): BelongsTo
    {
        return $this->belongsTo(ApiService::class);
    }
}
