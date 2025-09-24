<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Account extends Model
{
    use HasFactory,
        Notifiable,
        HasApiTokens;

    //***** Relations *****
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class);
    }
}
