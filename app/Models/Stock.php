<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    const INTEGRATION_TEST = 'stocks';
    public $timestamps = false;
    protected $fillable = [

    ];
}
