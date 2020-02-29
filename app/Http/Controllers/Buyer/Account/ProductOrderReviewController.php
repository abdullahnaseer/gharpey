<?php

namespace App\Http\Controllers\Buyer\Account;

use App\Http\Controllers\Controller;
use App\Models\ProductOrder;
use App\Models\ProductReview;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductOrderReviewController extends Controller
{
    public function index(Request $request, $product_order_id)
    {
        $porduct_order = ProductOrder::whereHas('order', function (Builder $query){
            $query->where('buyer_id', auth()->id());
        })->findOrFail($product_order_id);

        return $porduct_order;
    }


    public function create(Request $request)
    {

    }


    public function store(Request $request, $product_order_id)
    {
        $data = $request->validate([
            'review' => ['max:1000'],
            'rating' => ['required', 'min:1', 'max:5']
        ]);

        $product_order = ProductOrder::whereHas('order', function (Builder $query){
            $query->where('buyer_id', auth()->id());
        })->findOrFail($product_order_id);

        $review = ProductReview::create($data);
        $product_order->update(['reviewed_at' => Carbon::now()]);

        flash()->success(['Product reviewed successfully.']);
        return redirect()->back();
    }
}
