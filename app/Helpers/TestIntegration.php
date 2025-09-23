<?php

namespace App\Helpers;

use App\Models\Order;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Model;

class TestIntegration
{
    public static function getClass(string $routeName)
    {
        switch ($routeName){
            case Order::INTEGRATION_TEST:
                return Order::class;
            case Sale::INTEGRATION_TEST:
                return Sale::class;
        }
        return '';
    }
}
