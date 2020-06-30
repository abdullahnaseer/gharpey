<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\SellerWithdraw;
use App\Models\Seo;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Display a listing of the users who are eligible for withdraws.
     *
     * @return mixed
     */
    public function get()
    {
        $sellers = Seller::with(['payment_detail', 'last_transaction'])->get();
        $sellers_with_withdrawable_balance = collect([]);

        foreach ($sellers as $seller) {
            $total_withdrawn = (int) -$seller->transactions()->where('reference_type', SellerWithdraw::class)->sum('amount');
            $withdraw_able = (int) $seller->transactions()->withdrawable()->sum('amount') - $total_withdrawn;

            if (!is_null($seller->payment_detail)) {
                if ($withdraw_able >= (int) $seller->payment_detail->threshold)
                {
                    $seller->total_withdrawn = $seller->transactions()->where('reference_type', SellerWithdraw::class)->sum('amount');
                    $seller->withdrawable = $withdraw_able;
                    $sellers_with_withdrawable_balance->push($seller);
                }
            }
        }

        return view('admin.payment', ['users' => $sellers_with_withdrawable_balance]);
    }

    /**
     * Withdraws amount for selected users.
     *
     * @return mixed
     */
    public function post(Request $request)
    {
        $sellers = Seller::whereIn('id', $request->input('users', []))->with('last_transaction')->get();
        foreach ($sellers as $seller) {
            $total_withdrawn = (int) -$seller->transactions()->where('reference_type', SellerWithdraw::class)->sum('amount');
            $withdraw_able = (int) $seller->transactions()->withdrawable()->sum('amount') - $total_withdrawn;
            $withdraw_able = $withdraw_able <= 0 ? 0: $withdraw_able;

            $profit_percentage = (float) env('APP_PROFIT_PERCENTAGE', 5);
            $withdraw_able = $withdraw_able * ($profit_percentage / 100);

            if (!is_null($seller->payment_detail)) {
                if ($withdraw_able >= $seller->payment_detail->threshold) {
                    $transaction = $seller->transactions()->create([
                        'reference_type' => SellerWithdraw::class,
                        'type' => Transaction::TYPE_DEBIT,
                        'amount' => -$withdraw_able,
                        'balance' => $seller->transactions()->sum('amount') - $withdraw_able,
                        'note' => '',
                    ]);

                    $withdraw = $seller->withdraws()->create([
                        'transaction_id' => $transaction->id,
                        'amount' => $withdraw_able,
                        'name' => $seller->payment_detail->name,
                        'bank' => $seller->payment_detail->bank,
                        'account_no' => $seller->payment_detail->account_no,
                    ]);

                    $transaction->update(['reference_id' => $withdraw->id]);
                }
            }
        }

        flash()->success('Payment processed successfully!');
        return redirect('/admin/payments');
    }

}
