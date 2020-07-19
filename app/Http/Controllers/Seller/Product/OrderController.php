<?php

namespace App\Http\Controllers\Seller\Product;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductOrder;
use App\Models\Seller;
use App\Models\Transaction;
use App\Notifications\Buyer\ProductOrder\ProductOrderConfirmedNotification;
use App\Notifications\Seller\ProductOrder\ProductOrderNotification as BuyerProductOrderCanceledNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
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
        $orders = auth('seller')
            ->user()
            ->product_orders()
            ->withTrashedParents()
            ->orderBy('created_at', 'desc')
            ->with(['product' => function($query) {
                return $query->withTrashed();
            }])
            ->get();
        return $orders;
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        return view('seller.products.orders.index');
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
        $product_order = ProductOrder::with([
            'order',
            'product' => function($query) { return $query->withTrashed(); },
            'order.buyer' => function($query) { return $query->withTrashed(); }
        ])->findOrFail($id);

        $status = $request->input('status');
        if ($status == 'confirmed') {
            if ($product_order->status == ProductOrder::STATUS_NEW) {
                $product_order->update([
                    'status' => ProductOrder::STATUS_CONFIRMED,
                    'confirmed_at' => Carbon::now()
                ]);

                $buyer = $product_order->order->buyer;
                if (!is_null($buyer))
                    $buyer->notify(new ProductOrderConfirmedNotification($product_order));
                else if ( !empty($product_order->order) && !empty($product_order->order->receipt_email) )
                    $product_order->order->notify(new ProductOrderConfirmedNotification($product_order));

                flash()->success('Product Order Confirmed successfully.');
            } else
                flash()->error('Invalid Operation!!!');
        } else if ($status == 'delivered') {
            if (($product_order->status == ProductOrder::STATUS_NEW) || ($product_order->status == ProductOrder::STATUS_CONFIRMED))
                $product_order->update([
                    'status' => ProductOrder::STATUS_SELLER_SENT,
                    'seller_send_at' => Carbon::now()
                ]);
            else
                flash()->error('Invalid Operation!!!');

            flash()->success('Product Order marked for delivery successfully.');
        } else if ($status == 'cancel') {
            if ($product_order->status == ProductOrder::STATUS_NEW ||
                $product_order->status == ProductOrder::STATUS_CONFIRMED) {

                if($product_order->payment_gateway == Order::PAYMENT_GATEWAY_STRIPE)
                {
                    $buyer = $product_order->order->buyer;
                    Transaction::create([
                        'user_id' => is_null($buyer) ? null : $buyer->id,
                        'user_type' => Buyer::class,
                        'reference_id' => $product_order->id,
                        'reference_type' => ProductOrder::class,
                        'type' => Transaction::TYPE_CREDIT,
                        'amount' => $product_order->price,
                        'balance' => is_null($buyer) ? null : $buyer->transactions()->sum('amount') + $product_order->price,
                        'note' => '',
                    ]);
                }

                $product_order->update([
                    'status' => ProductOrder::STATUS_CANCELED,
                    'canceled_at' => Carbon::now()
                ]);

                if (!is_null($buyer))
                    $buyer->notify(new BuyerProductOrderCanceledNotification($product_order));
                else if ( !empty($product_order->order) && !empty($product_order->order->receipt_email) )
                    $product_order->order->notify(new BuyerProductOrderCanceledNotification($product_order));

                flash()->success('Product Order Canceled successfully.');
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
