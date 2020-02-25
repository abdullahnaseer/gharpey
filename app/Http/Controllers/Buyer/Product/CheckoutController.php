<?php

namespace App\Http\Controllers\Buyer\Product;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\City;
use App\Models\CityArea;
use App\Models\Order;
use App\Models\ProductOrder;
use App\Models\Seller;
use App\Notifications\Seller\ProductOrder\ProductOrderNotification;
use App\Rules\Phone;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display a form for shipping location.
     *
     * @return \Illuminate\Http\Response
     */
    public function getShipping(Request $request)
    {
        $cart = \Cart::session($request->session()->get('_token'));

        return view('buyer.products.checkout.shipping', [
            'user' => auth()->user(),
            'cart' => $cart,
            'cities' => City::with(['areas'])->get()
        ]);
    }

    /**
     * Save shipping information and proceed to payment.
     *
     * @return \Illuminate\Http\Response
     */
    public function postShipping(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'min:8'],
            'address' => ['required', 'string', 'min:8'],
            'area' => ['required', 'integer', 'exists:city_areas,id'],
            'phone' => ['required', new Phone()]
        ]);

        $request->session()->put('shipping', $validatedData);

        return redirect()->route('buyer.checkout.payment.get');
    }


    /**
     * Display a form for payment.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPayment(Request $request)
    {
        $cart = \Cart::session($request->session()->get('_token'));
        $shipping = $request->session()->get('shipping');

        if (is_null($shipping))
        {
            flash()->error('Enter Shipping Information before proceeding to payment.');
            return redirect()->route('buyer.checkout.payment.get');
        }

        $shipping['area'] = CityArea::with(['city', 'city.state', 'city.state.country'])->findOrfail($shipping['area']);

        return view('buyer.products.checkout.payment', [
            'user' => auth()->user(),
            'cart' => $cart,
            'shipping' => $shipping
        ]);
    }

    /**
     * Save shipping information and proceed to payment.
     *
     * @return \Illuminate\Http\Response
     */
    public function postPayment(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'min:8'],
            'address' => ['required', 'string', 'min:8'],
            'area' => ['required', 'integer', 'exists:city_areas,id'],
            'phone' => ['required', new Phone()]
        ]);

        $request->session()->put('shipping', $validatedData);

        return redirect()->route('buyer.checkout.payment.get');
    }

    /**
     * Process the payment for order.
     *
     * @param Request $request
     */
    public function charge(Request $request)
    {
        $cart = \Cart::session($request->session()->get('_token'));
        $shipping = $request->session()->get('shipping');
        $amount = $cart->getTotal();
        $buyer = auth('buyer')->check() ? auth()->user() : null;

        try {
            // Set your secret key: remember to change this to your live secret key in production
            // See your keys here: https://dashboard.stripe.com/account/apikeys
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            // Token is created using Checkout or Elements!
            // Get the payment token ID submitted by the form:
            $charge = \Stripe\Charge::create([
                'amount' => (int) ($amount * 100),
                'currency' => 'pkr',
                'description' => 'Charge for Product Order',
                'source' => $request->input('stripeToken'),
                'receipt_email' => is_null($buyer) ? null : $buyer->email
            ]);

            $order = Order::create([
                'buyer_id' => is_null($buyer) ? null : $buyer->id,
                'shipping_phone' => $shipping['phone'],
                'shipping_address' => $shipping['address'],
                'shipping_location_id' => $shipping['area'],
                'charge_id' => $charge->id,
                'paid_at' => Carbon::now()
            ]);

            foreach ($cart->getContent() as $item)
            {
                $productOrder = ProductOrder::create([
                    'order_id' => $order->id,
                    'product_id' => $item->model->id,
                    'price' => $item->getPriceSum(),
                    'quantity' => $item->quantity,
                ]);

                $seller = $item->model->seller;

                \App\Models\Transaction::create([
                    'user_id' => $seller->id,
                    'user_type' => Seller::class,
                    'reference_id' => $productOrder->id,
                    'reference_type' => \App\Models\ProductOrder::class,
                    'type' => \App\Models\Transaction::TYPE_CREDIT,
                    'amount' => $item->getPriceSum(),
                    'balance' => $seller->transactions()->sum('amount') + $item->getPriceSum(),
                    'note' => '',
                ]);

                $seller->notify(new ProductOrderNotification($productOrder));
            }

            \App\Models\Transaction::create([
                'user_id' => is_null($buyer) ? null : $buyer->id,
                'user_type' => Buyer::class,
                'reference_id' => $order->id,
                'reference_type' => \App\Models\Order::class,
                'type' => \App\Models\Transaction::TYPE_CREDIT,
                'amount' => $amount,
                'balance' => is_null($buyer) ? null : $buyer->transactions()->sum('amount') + $amount,
                'note' => '',
            ]);

            \App\Models\Transaction::create([
                'user_id' => is_null($buyer) ? null : $buyer->id,
                'user_type' => Buyer::class,
                'reference_id' => $order->id,
                'reference_type' => \App\Models\Order::class,
                'type' => \App\Models\Transaction::TYPE_DEBIT,
                'amount' => -$amount,
                'balance' => is_null($buyer) ? null : $buyer->transactions()->sum('amount') - $amount,
                'note' => '',
            ]);

            $cart->clear();

            return response()->json(['success' => 'Payment was successful']);
        } catch (\Exception $ex) {
//            return $ex->getMessage();
            return response()->json(['error' => $ex->getMessage()]);
//            return response()->json(['error' => 'Payment was declined']);
        }
    }

    public function success()
    {
        return view('buyer.products.checkout.success');
    }
}
