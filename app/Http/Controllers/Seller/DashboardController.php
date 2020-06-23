<?php

namespace App\Http\Controllers\Seller;

use App\Helpers\ChartData;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:seller');
        $this->middleware('seller.approved');
    }

    /**
     * Show the application dashboard for seller.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('seller.dashboard', [
            'charts' => [
                [
                    'id' => 'revenues',
                    'name' => 'Revenues',
                    'size' => 'col-sm-12',
                    'data' => ChartData::getSellerRevenuesChartData(auth('seller')->id())
                ],
                [
                    'id' => 'revenues-products',
                    'name' => 'Revenues From Products',
                    'data' => ChartData::getSellerProductRevenuesChartData(auth('seller')->id())
                ],
                [
                    'id' => 'revenues-services',
                    'name' => 'Revenues from Services',
                    'data' => ChartData::getSellerServiceRevenuesChartData(auth('seller')->id())
                ],
                [
                    'id' => 'product-sales',
                    'name' => 'Product Sales',
                    'data' => ChartData::getSellerProductSalesChartData(auth('seller')->id())
                ],
                [
                    'id' => 'service-requests',
                    'name' => 'Service Requests',
                    'data' => ChartData::getSellerServiceRequestsChartData(auth('seller')->id())
                ],
            ]
        ]);
    }
}
