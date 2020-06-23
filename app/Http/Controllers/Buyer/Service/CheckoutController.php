<?php

namespace App\Http\Controllers\Buyer\Service;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\City;
use App\Models\CityArea;
use App\Models\Order;
use App\Models\ProductOrder;
use App\Models\Seller;
use App\Models\ServiceRequest;
use App\Models\Transaction;
use App\Notifications\Seller\ProductOrder\ProductOrderNotification;
use App\Notifications\Seller\ServiceRequest\ServiceRequestNotification;
use App\Rules\Phone;
use Carbon\Carbon;
use Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stripe\Charge;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    /**
     * Display a form for shipping location.
     *
     * @return mixed
     */
    public function getShipping(Request $request, $service_request_id)
    {
        $cart = Cart::session($request->session()->get('_token'));
        $service_request = ServiceRequest::unpaid()
            ->with(['service_seller', 'service_seller.service'])
            ->findOrFail($service_request_id);

        return view('buyer.services.checkout.shipping', [
            'user' => auth()->user(),
            'service_request' => $service_request,
            'cities' => City::with(['areas'])->get()
        ]);
    }

    /**
     * Save shipping information and proceed to payment.
     *
     * @return mixed
     */
    public function postShipping(Request $request, $service_request_id)
    {
        $service_request = ServiceRequest::unpaid()
            ->with(['service_seller', 'service_seller.service'])
            ->findOrFail($service_request_id);

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'min:8'],
            'email' => auth('buyer')->check() ? '' : 'required|email',
            'phone' => ['required', new Phone()],
            'password' => auth('buyer')->check() ? '' : 'required|min:8',
            'address' => ['required', 'string', 'min:8'],
            'area' => ['required', 'integer', 'exists:city_areas,id'],
        ]);

        // Register User here And Login them

        $service_request->update(['location_id' => CityArea::findOrFail((int) $request->input('area'))->city_id]);
        if(auth()->check())
            $service_request->update(['buyer_id' => auth()->id()]);

        $request->session()->put('shipping', $validatedData);

        return redirect()->route('buyer.service.checkout.payment.get', [$service_request->id]);
    }

    /**
     * Display a form for payment.
     *
     * @return mixed
     */
    public function getPayment(Request $request, $service_request_id)
    {
        $service_request = ServiceRequest::unpaid()
            ->with(['service_seller', 'service_seller.service'])
            ->findOrFail($service_request_id);

        $shipping = $request->session()->get('shipping');

        if (is_null($shipping)) {
            flash()->error('Enter Shipping Information before proceeding to payment.');
            return redirect()->route('buyer.service.checkout.payment.get');
        }

        $shipping['area'] = CityArea::with(['city', 'city.state', 'city.state.country'])->findOrfail($shipping['area']);

        return view('buyer.services.checkout.payment', [
            'user' => auth('buyer')->user(),
            'service_request' => $service_request,
            'shipping' => $shipping
        ]);
    }

    /**
     * Save shipping information and proceed to payment.
     *
     * @return mixed
     */
    public function postPayment(Request $request, $service_request_id)
    {
        $service_request = ServiceRequest::unpaid()
            ->with(['service_seller', 'service_seller.service'])
            ->findOrFail($service_request_id);

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'min:8'],
            'address' => ['required', 'string', 'min:8'],
            'area' => ['required', 'integer', 'exists:city_areas,id'],
            'phone' => ['required', new Phone()]
        ]);

        $request->session()->put('shipping', $validatedData);

        return redirect()->route('buyer.service.checkout.payment.get', [$service_request->id]);
    }

    /**
     * Process the payment for order.
     *
     * @param Request $request
     */
    public function charge(Request $request, $service_request_id)
    {
        $service_request = ServiceRequest::unpaid()
            ->with(['service_seller', 'service', 'seller'])
            ->findOrFail($service_request_id);

        $shipping = $request->session()->get('shipping');
        $amount = $service_request->total_amount;
        $buyer = auth('buyer')->check() ? auth()->user() : null;
        $seller = $service_request->seller;

        try {
            // Set your secret key: remember to change this to your live secret key in production
            // See your keys here: https://dashboard.stripe.com/account/apikeys
            Stripe::setApiKey(config('services.stripe.secret'));

            // Token is created using Checkout or Elements!
            // Get the payment token ID submitted by the form:
            $charge = Charge::create([
                'amount' => (int)($amount * 100),
                'currency' => 'pkr',
                'description' => 'Charge for Product Order',
                'source' => $request->input('stripeToken'),
                'receipt_email' => is_null($buyer) ? null : $buyer->email
            ]);

            $service_request->update([
                'shipping_phone' => $shipping['phone'],
                'shipping_address' => $shipping['address'],
                'shipping_location_id' => $shipping['area'],
                'receipt_email' => is_null($buyer) ? $shipping['email'] : $buyer->email,
                'charge_id' => $charge->id,
                'status' => ServiceRequest::STATUS_PAID,
                'paid_at' => Carbon::now()
            ]);

            Transaction::create([
                'user_id' => is_null($buyer) ? null : $buyer->id,
                'user_type' => Buyer::class,
                'reference_id' => $service_request->id,
                'reference_type' => ServiceRequest::class,
                'type' => Transaction::TYPE_CREDIT,
                'amount' => $amount,
                'balance' => is_null($buyer) ? null : $buyer->transactions()->sum('amount') + $amount,
                'note' => '',
            ]);

            Transaction::create([
                'user_id' => is_null($buyer) ? null : $buyer->id,
                'user_type' => Buyer::class,
                'reference_id' => $service_request->id,
                'reference_type' => ServiceRequest::class,
                'type' => Transaction::TYPE_DEBIT,
                'amount' => -$amount,
                'balance' => is_null($buyer) ? null : $buyer->transactions()->sum('amount') - $amount,
                'note' => '',
            ]);

            $seller->notify(new ServiceRequestNotification($service_request));

            return response()->json(['success' => 'Payment was successful']);
        } catch (Exception $ex) {
//            return $ex->getMessage();
            return response()->json(['error' => $ex->getMessage()]);
//            return response()->json(['error' => 'Payment was declined']);
        }
    }

    public function success($service_request_id)
    {
        return view('buyer.services.checkout.success');
    }
}
