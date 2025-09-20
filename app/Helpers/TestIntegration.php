<?php

namespace App\Helpers;

use App\Models\Order;
use App\Models\Sale;

class TestIntegration
{
    public static function getModel(string $routeName)
    {
        switch ($routeName){
            case Order::INTEGRATION_TEST:
                return Order::query();
            case Sale::INTEGRATION_TEST:
                return Sale::query();
        }
    }
}
