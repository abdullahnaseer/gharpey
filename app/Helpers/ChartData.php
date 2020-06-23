<?php


namespace App\Helpers;


use App\Models\Buyer;
use App\Models\Seller;
use App\Models\Transaction;

class ChartData
{
    public static function getRevenuesChartData()
    {
        return Transaction::credit()->selectRaw('sum(amount) as value, DATE(created_at) as date')->groupBy('date')->get()->toJson();
    }

    public static function getProfitsChartData()
    {
        return Transaction::selectRaw('sum(amount) as value, DATE(created_at) as date')->groupBy('date')->get()->toJson();
    }

    public static function getSellersChartData()
    {
        return Seller::selectRaw('count(id) as value, DATE(created_at) as date')->groupBy('date')->get()->toJson();
    }

    public static function getBuyersChartData()
    {
        return Buyer::selectRaw('count(id) as value, DATE(created_at) as date')->groupBy('date')->get()->toJson();
    }
}
