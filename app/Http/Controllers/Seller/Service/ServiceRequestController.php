<?php

namespace App\Http\Controllers\Seller\Service;

use App\Http\Controllers\Controller;
use App\Models\ProductOrder;
use App\Models\Seller;
use App\Models\ServiceRequest;
use App\Models\Transaction;
use App\Notifications\Buyer\ProductOrder\ProductOrderConfirmedNotification;
use App\Notifications\Buyer\ServiceRequest\ServiceRequestCanceledNotification;
use App\Notifications\Buyer\ServiceRequest\ServiceRequestConfirmNotification;
use App\Notifications\Seller\ProductOrder\ProductOrderNotification as BuyerProductOrderCanceledNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceRequestController extends Controller
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
     * Return a listing of the resource.
     *
     * @return mixed
     */
    public function json()
    {
        return auth('seller')
            ->user()
            ->service_requests()
            ->orderBy('created_at', 'desc')
            ->with([
                'service' => fn($q) => $q->withTrashed(),
                'buyer' => fn($q) => $q->withTrashed(),
                'seller' => fn($q) => $q->withTrashed(),
                'service_seller' => fn($q) => $q->withTrashed(),
                'answers',
                'answers.answer',
                'shipping_location',
                'shipping_location.city',
                'shipping_location.city.state'
            ])
            ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        return view('seller.services.requests.index');
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
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function edit(Request $request, $id)
    {
        $service_request = auth('seller')->user()->service_requests()
            ->with([
                'service' => fn($q) => $q->withTrashed(),
                'buyer' => fn($q) => $q->withTrashed(),
                'seller' => fn($q) => $q->withTrashed(),
            ])
            ->find($request->input('service_request_id'));

        $buyer = !is_null($service_request) ? $service_request->buyer : null;
        $seller = !is_null($service_request) ? $service_request->seller : null;

        $status = $request->input('status');
        if ($status == 'confirm') {
            if (is_null($service_request->completed_at)) {
                $service_request->update([
                    'status' => ServiceRequest::STATUS_CONFIRMED,
                    'confirmed_at' => Carbon::now()
                ]);

                if (!is_null($buyer))
                    $buyer->notify(new ServiceRequestConfirmNotification($service_request));

                flash()->success('Service Request Order Confirmed Successfully.');
            } else
                flash()->error('Invalid Operation!!!');
        } else if ($status == 'cancel') {
            if (is_null($service_request->confirmed_at) && is_null($service_request->completed_at)) {
                $service_request->update([
                    'status' => ServiceRequest::STATUS_CANCELED,
                    'canceled_at' => Carbon::now()
                ]);

                if(!is_null($service_request->paid_at))
                {
                    if (!is_null($buyer))
                        $buyer->notify(new ServiceRequestCanceledNotification($service_request));
                }

                flash()->success('Service Request Order Canceled Successfully.');
            } else
                flash()->error('Invalid Operation!!!');
        } else {
            flash()->error('Invalid Operation!!!');
        }

        return redirect()->back();
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
