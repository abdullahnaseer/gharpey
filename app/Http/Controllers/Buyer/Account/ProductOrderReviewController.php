<?php

namespace App\Http\Controllers\Buyer\Account;

use App\Http\Controllers\Controller;
use App\Models\ProductOrder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductOrderReviewController extends Controller
{
    public function index(Request $request, $product_order_id)
    {
        return ProductOrder::whereHas('order', function (Builder $query) {
            $query->where('buyer_id', auth()->id());
        })->findOrFail($product_order_id);
    }

    public function store(Request $request, $product_order_id)
    {
        $data = $request->validate([
            'review' => ['max:1000'],
            'rating' => ['required', 'min:1', 'max:5']
        ]);

        $product_order = ProductOrder::whereHas('order', function (Builder $query) {
            $query->where('buyer_id', auth()->id());
        })->findOrFail($product_order_id);

        $data['product_id'] = $product_order->product_id;
        $review = $product_order->review()->create($data);
        $product_order->update(['reviewed_at' => Carbon::now()]);

        flash()->success('Product reviewed successfully.');
        return redirect()->back();
    }
}
