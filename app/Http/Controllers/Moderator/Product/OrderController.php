<?php

namespace App\Http\Controllers\Moderator\Product;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\Order;
use App\Models\ProductOrder;
use App\Models\Seller;
use App\Models\Transaction;
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
     * @return mixed
     */
    public function json(Request $request)
    {
        $seller_id = $request->input('seller_id');
        $buyer_id = $request->input('buyer_id');

        if(!is_null($seller_id)) {
            $orders = Seller::findOrFail($seller_id)->product_orders()->orderBy('created_at', 'desc')
                ->with(['product' => function ($query) {
                    return $query->withTrashed();
                }])
                ->get();
        } else if(!is_null($buyer_id))
        {
            $orders = Buyer::findOrFail($buyer_id)->product_orders()->orderBy('created_at', 'desc')
                ->with(['product' => function($query) {
                    return $query->withTrashed();
                }])
                ->get();
        } else {
            $orders = ProductOrder::orderBy('created_at', 'desc')
                ->with(['product' => function($query) {
                    return $query->withTrashed();
                }])
                ->get();
        }
        return $orders;
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        return view('moderator.products.orders.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param int $id
     *
     * @return mixed
     */
    public function edit(Request $request, $id)
    {
        $product_order = ProductOrder::with(['product' => function($query) {
            return $query->withTrashed();
        }])->findOrFail($id);

        $order = $product_order->order;
        $product = $product_order->product()->withTrashed()->first();

        $buyer = !is_null($order) ? $order->buyer()->withTrashed()->first() : null;
        $seller = !is_null($product) ? $product->seller()->withTrashed()->first() : null;

        $status = $request->input('status');
        if ($status == 'received') {
            if ($product_order->status == ProductOrder::STATUS_NEW || $product_order->status == ProductOrder::STATUS_SELLER_SENT || $product_order->status == ProductOrder::STATUS_CONFIRMED) {
                $product_order->update([
                    'status' => ProductOrder::STATUS_WAREHOUSE_RECEVIED,
                    'warehouse_received_at' => Carbon::now()
                ]);

                if(!is_null($seller))
                    $seller->notify(new ProductOrderReceivedNotification($product_order));

                flash()->success('Status Updated!');
            } else
                flash()->error('Invalid Operation!!!');
        } else if ($status == 'sent') {

            if ($product_order->status == ProductOrder::STATUS_WAREHOUSE_RECEVIED) {
                $product_order->update([
                    'status' => ProductOrder::STATUS_SENT,
                    'send_at' => Carbon::now()
                ]);

                if (!is_null($buyer))
                    $buyer->notify(new ProductOrderDeliveryNotification($product_order));
                else if ( !empty($product_order->order) && !empty($product_order->order->receipt_email) )
                    $product_order->order->notify(new ProductOrderDeliveryNotification($product_order));

                flash()->success('Status Updated!');
            } else
                flash()->error('Invalid Operation!!!');

        } else if ($status == 'completed') {
            if ($product_order->status == ProductOrder::STATUS_SENT) {
                $product_order->update([
                    'status' => ProductOrder::STATUS_COMPLETED,
                    'completed_at' => Carbon::now()
                ]);

                if($product_order->payment_gateway == Order::PAYMENT_GATEWAY_COD)
                {
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

                    Transaction::create([
                        'user_id' => is_null($buyer) ? null : $buyer->id,
                        'user_type' => Buyer::class,
                        'reference_id' => $product_order->id,
                        'reference_type' => ProductOrder::class,
                        'type' => Transaction::TYPE_DEBIT,
                        'amount' => -$product_order->price,
                        'balance' => is_null($buyer) ? null : $buyer->transactions()->sum('amount') - $product_order->price,
                        'note' => '',
                    ]);
                }

                Transaction::create([
                    'user_id' => is_null($seller) ? null : $seller->id,
                    'user_type' => Seller::class,
                    'reference_id' => $product_order->id,
                    'reference_type' => ProductOrder::class,
                    'type' => Transaction::TYPE_CREDIT,
                    'amount' => $product_order->price,
                    'balance' => is_null($seller) ? null : $seller->transactions()->sum('amount') + $product_order->price,
                    'note' => '',
                ]);

                if (!is_null($buyer))
                    $buyer->notify(new ProductOrderCompletedNotification($product_order));
                else if ( !empty($product_order->order) && !empty($product_order->order->receipt_email) )
                    $product_order->order->notify(new ProductOrderCompletedNotification($product_order));

                flash()->success('Status Updated!');
            } else
                flash()->error('Invalid Operation!!!');
        } else if ($status == 'cancel') {
            if ($product_order->status == ProductOrder::STATUS_NEW) {
                $product_order->update([
                    'status' => ProductOrder::STATUS_CANCELED,
                    'canceled_at' => Carbon::now()
                ]);

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

                if(!is_null($seller))
                    $seller->notify(new ProductOrderCanceledNotification($product_order));

                if (!is_null($buyer))
                    $buyer->notify(new BuyerProductOrderCanceledNotification($product_order));
                else if ( !empty($order) && !empty($order->receipt_email) )
                    $order->notify(new BuyerProductOrderCanceledNotification($product_order));

                flash()->success('Status Updated!');
            } else
                flash()->error('Invalid Operation!!!');
        } else {
            flash()->error('Invalid Operation!!!');
        }

        return redirect()->back();
    }
}
