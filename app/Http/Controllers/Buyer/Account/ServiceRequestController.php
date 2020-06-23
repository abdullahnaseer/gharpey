<?php

namespace App\Http\Controllers\Buyer\Account;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\ServiceRequest;
use App\Models\Transaction;
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
        $seller = !is_null($service_request) ? $service_request->seller : null;
        if($request->input('action') == 'release' && !is_null($service_request) && !is_null($seller) && $service_request->status == ServiceRequest::STATUS_CONFIRMED)
        {
            $service_request->update([
                'status' => ServiceRequest::STATUS_COMPLETED,
                'completed_at' => Carbon::now()
            ]);

            Transaction::create([
                'user_id' => $seller->id,
                'user_type' => Seller::class,
                'reference_id' => $service_request->id,
                'reference_type' => ServiceRequest::class,
                'type' => Transaction::TYPE_CREDIT,
                'amount' => $service_request->total_amount,
                'balance' => $seller->transactions()->sum('amount') + $service_request->total_amount,
                'note' => '',
            ]);

            flash()->success('Payment Released Successfully! Write Review For Seller to help us improve experience of Website.');
        } else if ($request->input('action') == 'release') {
            flash()->error('Payment Already Released for this Service Request or Seller Account is on Hold at the moment!');
        }

        return view('buyer.account.service_requests.index', [
            'service_requests' => auth()->user()->service_requests()->with(['service_seller', 'service_seller.service', 'answers'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return mixed
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return mixed
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return mixed
     */
    public function destroy($id)
    {
        //
    }
}
