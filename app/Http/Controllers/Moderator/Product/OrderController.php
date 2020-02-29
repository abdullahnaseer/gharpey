<?php

namespace App\Http\Controllers\Moderator\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductOrder;
use App\Models\Seller;
use App\Notifications\Buyer\ProductOrder\ProductOrderCompletedNotification;
use App\Notifications\Buyer\ProductOrder\ProductOrderDeliveryNotification;
use App\Notifications\Seller\ProductOrder\ProductOrderCanceledNotification;
use App\Notifications\Seller\ProductOrder\ProductOrderNotification as BuyerProductOrderCanceledNotification;
use App\Notifications\Seller\ProductOrder\ProductOrderReceivedNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin,moderator');
    }

    /**
     * Return a listing of the resource.
     *
     * @return Response
     */
    public function json()
    {
        $orders = ProductOrder::orderBy('created_at', 'desc')
            ->with(['product'])
            ->get();
        return $orders;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('moderator.products.orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
        $product_order = ProductOrder::findOrFail($id);
        $buyer = $product_order->order->buyer;
        $seller = $product_order->product->seller;
        $status = $request->input('status');
        if($status == 'received') {
            if($product_order->status == ProductOrder::STATUS_PAID || $product_order->status == ProductOrder::STATUS_SELLET_SENT) {
                $product_order->update([
                    'status' => ProductOrder::STATUS_WAREHOUSE_RECEVIED,
                    'warehouse_received_at' => Carbon::now()
                ]);

                $product_order->product->seller->notify(new ProductOrderReceivedNotification($product_order));

                flash()->success('Status Updated!');
            }
            else
                flash()->error('Invalid Operation!!!');
        } else if ($status == 'sent') {
            if($product_order->status == ProductOrder::STATUS_WAREHOUSE_RECEVIED) {
                $product_order->update([
                    'status' => ProductOrder::STATUS_SENT,
                    'send_at' => Carbon::now()
                ]);

                if(!is_null($buyer))
                    $buyer->notify(new ProductOrderDeliveryNotification($product_order));

                flash()->success('Status Updated!');
            }
            else
                flash()->error('Invalid Operation!!!');
        } else if ($status == 'completed') {
            if($product_order->status == ProductOrder::STATUS_SENT) {
                $product_order->update([
                    'status' => ProductOrder::STATUS_COMPLETED,
                    'completed_at' => Carbon::now()
                ]);

                if(!is_null($buyer))
                    $buyer->notify(new ProductOrderCompletedNotification($product_order));

                flash()->success('Status Updated!');
            }
            else
                flash()->error('Invalid Operation!!!');
        } else if ($status == 'cancel') {
            if($product_order->status == ProductOrder::STATUS_PAID) {
                $product_order->update([
                    'status' => ProductOrder::STATUS_CANCELED,
                    'canceled_at' => Carbon::now()
                ]);

                \App\Models\Transaction::create([
                    'user_id' => $product_order->product->seller->id,
                    'user_type' => Seller::class,
                    'reference_id' => $product_order->id,
                    'reference_type' => \App\Models\ProductOrder::class,
                    'type' => \App\Models\Transaction::TYPE_DEBIT,
                    'amount' => -$product_order->price,
                    'balance' => $product_order->product->seller->transactions()->sum('amount') - $product_order->price,
                    'note' => '',
                ]);

                $buyer = $product_order->order->buyer;
                \App\Models\Transaction::create([
                    'user_id' => is_null($buyer) ? null : $buyer->id,
                    'user_type' => Seller::class,
                    'reference_id' => $product_order->id,
                    'reference_type' => \App\Models\ProductOrder::class,
                    'type' => \App\Models\Transaction::TYPE_CREDIT,
                    'amount' => $product_order->price,
                    'balance' => is_null($buyer) ? null : $buyer->transactions()->sum('amount') + $product_order->price,
                    'note' => '',
                ]);

                $product_order->product->seller->notify(new ProductOrderCanceledNotification($product_order));
                if(!is_null($buyer))
                    $buyer->notify(new BuyerProductOrderCanceledNotification($product_order));

                flash()->success('Status Updated!');
            }
            else
                flash()->error('Invalid Operation!!!');
        } else {
            flash()->error('Invalid Operation!!!');
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
