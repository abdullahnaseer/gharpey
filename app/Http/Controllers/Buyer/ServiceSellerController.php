<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Referral;
use App\Models\Service;
use App\Models\ServiceSeller;
use App\Models\User;
use App\Rules\ServiceRequestLocation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ServiceSellerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }


    /**
     * Show the service page.
     *
     * @return Response
     */
    public function show(Request $request, $service_slug, $service_seller_id)
    {
        $cities = City::all();
        $city = City::find($request->input('city_id'));
        $service_seller = ServiceSeller::with(['seller'])
            ->whereHas('cities', function (Builder $query) use ($request) {
                if ($request->has('city_id'))
                    $query->where('location_id', $request->input('city_id'));
            })
            ->findOrFail($service_seller_id);
        $service = Service::where('slug', $service_slug)
            ->with(['category', 'questions'])
            ->findOrFail($service_seller->service_id);

        return view('buyer.services.sellers.show', [
            'service' => $service,
            'service_seller' => $service_seller,
            'cities' => $cities,
            'city' => $city
        ]);
    }

}
