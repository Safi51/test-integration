<?php

namespace App\Helpers;

use App\Models\Income;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Stock;
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
            case Stock::INTEGRATION_TEST:
                return Stock::class;
            case Income::INTEGRATION_TEST:
                return Income::class;
        }
        return '';
    }
    public static function getUnique($routeName)
    {
        switch ($routeName){
            case Order::INTEGRATION_TEST:
                return [
                    'g_number'
                ];
            case Sale::INTEGRATION_TEST:
                return [
                    'g_number'
                ];
            case Stock::INTEGRATION_TEST:
                return [
                    'barcode',
                    'warehouse_name'
                ];
            case Income::INTEGRATION_TEST:
                return [
                    'barcode',
                    'income_id'
                ];
        }
        return '';
    }
}
