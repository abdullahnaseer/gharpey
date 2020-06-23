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

    public static function getSellerRevenuesChartData($seller_id)
    {
        return Seller::findOrFail($seller_id)->transactions()->selectRaw('sum(amount) as value, DATE(created_at) as date')->groupBy('date')->get()->toJson();
    }

    public static function getSellerProductRevenuesChartData($seller_id)
    {
        return Seller::findOrFail($seller_id)->transactions()->product()->selectRaw('sum(amount) as value, DATE(created_at) as date')->groupBy('date')->get()->toJson();
    }

    public static function getSellerServiceRevenuesChartData($seller_id)
    {
        return Seller::findOrFail($seller_id)->transactions()->service()->selectRaw('sum(amount) as value, DATE(created_at) as date')->groupBy('date')->get()->toJson();
    }

    public static function getSellerProductSalesChartData($seller_id)
    {
        return Seller::findOrFail($seller_id)->product_orders()->completed()->selectRaw('count(product_order.id) as value, DATE(product_order.created_at) as date')->groupBy('date')->get()->toJson();
    }

    public static function getSellerServiceRequestsChartData($seller_id)
    {
        return Seller::findOrFail($seller_id)->service_requests()->completed()->selectRaw('count(id) as value, DATE(created_at) as date')->groupBy('date')->get()->toJson();
    }
}