<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApiService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    //***** Relations *****
    public function tokenSlugs(): BelongsToMany
    {
        return $this->belongsToMany(
            TokenType::class,
            'api_service_token_types',
            'api_service_id',
            'token_type_slug',
            'id',
            'slug'
        );    }
}
