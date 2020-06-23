<?php

namespace App\Http\Controllers\Buyer\Account;

use App\Http\Controllers\Controller;
use App\Models\ProductOrder;
use App\Models\ServiceRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ServiceRequestReviewController extends Controller
{
    public function index(Request $request, $service_request_id)
    {
        return auth()->user()->service_requests()->findOrFail((int) $service_request_id);
    }

    public function create(Request $request)
    {

    }

    public function store(Request $request, $service_request_id)
    {
        $service_request = auth()->user()->service_requests()->findOrFail((int) $service_request_id);

        $data = $request->validate([
            'review' => ['max:1000'],
            'rating' => ['required', 'min:1', 'max:5']
        ]);

        $data['service_seller_id'] = $service_request->service_seller_id;
        $data['buyer_id'] = auth()->id();
        $review = $service_request->review()->create($data);
        $service_request->update(['reviewed_at' => Carbon::now()]);

        flash()->success('Service Request Reviewed Successfully!');
        return redirect()->to('/account/service-requests');
    }
}
