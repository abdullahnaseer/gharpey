<?php

namespace App\Http\Controllers\Buyer\Account;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\Seller;
use App\Models\ServiceRequest;
use App\Models\Transaction;
use App\Notifications\Seller\ServiceRequest\ServiceRequestCompleteNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $service_request = auth()->user()->service_requests()->find($request->input('service_request_id'));
        $buyer = !is_null($service_request) ? $service_request->buyer : null;
        $seller = !is_null($service_request) ? $service_request->seller : null;
        if($request->input('action') == 'release' && !is_null($service_request) && !is_null($seller) && $service_request->status == ServiceRequest::STATUS_CONFIRMED)
        {
            $service_request->update([
                'status' => ServiceRequest::STATUS_COMPLETED,
                'completed_at' => Carbon::now()
            ]);

            Transaction::create([
                'user_id' => is_null($buyer) ? $buyer->id : null,
                'user_type' => Buyer::class,
                'reference_id' => $service_request->id,
                'reference_type' => ServiceRequest::class,
                'type' => Transaction::TYPE_DEBIT,
                'amount' => -$service_request->total_amount,
                'balance' => is_null($buyer) ? $buyer->transactions()->sum('amount') - $service_request->total_amount : null,
                'note' => '',
            ]);

            Transaction::create([
                'user_id' => is_null($seller) ? $seller->id : null,
                'user_type' => Seller::class,
                'reference_id' => $service_request->id,
                'reference_type' => ServiceRequest::class,
                'type' => Transaction::TYPE_CREDIT,
                'amount' => $service_request->total_amount,
                'balance' => is_null($seller) ? $seller->transactions()->sum('amount') + $service_request->total_amount : null,
                'note' => '',
            ]);

            $seller->notify(new ServiceRequestCompleteNotification($service_request));
            flash()->success('Payment Released Successfully! Write Review For Seller to help us improve experience of Website.');
        } else if ($request->input('action') == 'release') {
            flash()->error('Payment Already Released for this Service Request or Seller Account is on Hold at the moment!');
        }

        return view('buyer.account.service_requests.index', [
            'service_requests' => auth()->user()->service_requests()->with(['service_seller', 'service_seller.service', 'answers'])->get()
        ]);
    }
}
