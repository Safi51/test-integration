<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Token extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'account_id',
        'type_slug',
        'token',
        'expires_at',
        'api_service_id',
    ];

    //***** Relations *****
    public function type(): BelongsTo
    {
        return $this->belongsTo(TokenType::class, 'type_slug', 'slug');
    }
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
