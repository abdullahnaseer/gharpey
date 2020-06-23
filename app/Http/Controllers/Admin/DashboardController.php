<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ChartData;
use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\Seller;
use App\Models\Transaction;
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
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard for admin.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('admin.dashboard', [
            'charts' => [
                [
                    'id' => 'revenues',
                    'name' => 'Revenues',
                    'data' => ChartData::getRevenuesChartData()
                ],
                [
                    'id' => 'profits',
                    'name' => 'Profits',
                    'data' => ChartData::getProfitsChartData()
                ],
                [
                    'id' => 'sellers',
                    'name' => 'Sellers Joining GharPey',
                    'data' => ChartData::getSellersChartData()
                ],
                [
                    'id' => 'buyers',
                    'name' => 'Buyers Joining GharPey',
                    'data' => ChartData::getBuyersChartData()
                ],
            ],
        ]);
    }

}
