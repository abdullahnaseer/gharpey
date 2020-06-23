<?php

namespace App\Http\Controllers\Seller;

use App\Helpers\ChartData;
use App\Http\Controllers\Controller;
use App\Models\SellerWithdraw;
use App\Models\Transaction;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class FinanceController extends Controller
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
        $last_transaction = auth('seller')->user()->transactions()->orderBy('created_at', 'desc')->first();
        $total_withdrawn = auth('seller')->user()->transactions()->where('reference_type', SellerWithdraw::class)->sum('amount');
        $withdraw_able = auth('seller')->user()->transactions()->withdrawable()->sum('amount') - $total_withdrawn;
        $withdraw_able = $withdraw_able >= 0 ? $withdraw_able : 0;
        $lifetime_earnings = auth('seller')->user()->transactions()->where('type', Transaction::TYPE_CREDIT)->orderBy('created_at', 'desc')->sum('amount');

        return view('seller.finance', [
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
            ],
            'payment_detail' => auth('seller')->user()->payment_detail,
            'banks' => $this->getBanks(),
            'threshold_amounts' => $this->getAmounts(),
            'current_balance' => is_null($last_transaction) ? 0 : $last_transaction->balance,
            'total_withdrawn' => $total_withdrawn >= 0 ? $total_withdrawn : 0,
            'withdraw_able' => $withdraw_able >= 0 ? $withdraw_able : 0,
            'lifetime_earnings' => $lifetime_earnings >= 0 ? $lifetime_earnings : 0,
        ]);
    }

    /**
     * Save Payment Information
     *
     * @return Renderable
     */
    public function payment(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'bank' => ['required', 'in:'.collect(range( 0, count($this->getBanks()) - 1 ))->implode(",")],
            'account_no' => ['required', 'min:10', 'max:30'],
            'threshold' => ['required', 'in:'.collect(range( 0, count($this->getAmounts()) - 1 ))->implode(",")],
        ]);

        $fields['bank'] = $this->getBanks()[$fields['bank']];
        $fields['threshold'] = $this->getAmounts()[$fields['threshold']];
        $payment = auth('seller')->user()->payment_detail;

        if(is_null($payment))
            auth('seller')->user()->payment_detail()->create($fields);
        else
            $payment->update($fields);

        flash()->success('Payment Information Updated Successfully!');
        return redirect()->route('seller.finance');
    }

    private function getBanks()
    {
        return [
            "Al Baraka Bank (Pakistan) Limited.",
            "Allied Bank Limited.",
            "Askari Bank Limited.",
            "Bank Alfalah Limited.",
            "Bank Al-Habib Limited.",
            "BankIslami Pakistan Limited.",
            "Citi Bank",
            "Deutsche Bank A.G.",
            "The Bank of Tokyo-Mitsubishi UFJ",
            "Dubai Islamic Bank Pakistan Limited.",
            "Faysal Bank Limited.",
            "First Women Bank Limited.",
            "Habib Bank Limited.",
            "Standard Chartered Bank (Pakistan) Limited.",
            "Habib Metropolitan Bank Limited.",
            "Industrial and Commercial Bank of China",
            "Industrial Development Bank of Pakistan",
            "JS Bank Limited.",
            "MCB Bank Limited.",
            "MCB Islamic Bank Limited.",
            "Meezan Bank Limited.",
            "National Bank of Pakistan",
            "S.M.E. Bank Limited.",
            "Samba Bank Limited.",
            "Silk Bank Limited",
            "Sindh Bank Limited.",
            "Soneri Bank Limited.",
            "Summit Bank Limited.",
            "The Bank of Khyber.",
            "The Bank of Punjab.",
            "The Punjab Provincial Cooperative Bank Limited.",
            "United Bank Limited.",
            "Zarai Taraqiati Bank Limited.",
        ];
    }

    private function getAmounts()
    {
        return [2000, 5000, 10000, 25000, 50000, 100000];
    }
}
