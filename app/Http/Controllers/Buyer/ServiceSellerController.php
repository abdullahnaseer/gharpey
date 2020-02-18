<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CityArea;
use App\Models\Referral;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceQuestion;
use App\Models\ServiceQuestionValidationRule;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestAnswer;
use App\Models\ServiceRequestAnswerBoolean;
use App\Models\ServiceRequestAnswerChoice;
use App\Models\ServiceRequestAnswerDate;
use App\Models\ServiceRequestAnswerDateTime;
use App\Models\ServiceRequestAnswerFile;
use App\Models\ServiceRequestAnswerText;
use App\Models\ServiceRequestAnswerTextMultiline;
use App\Models\ServiceRequestAnswerTime;
use App\Models\ServiceSeller;
use App\Models\State;
use App\Models\User;
use App\Rules\Phone;
use App\Rules\ServiceRequestLocation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


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
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $service_slug, $service_seller_id)
    {
        $cities = City::all();
        $city = City::find($request->input('city_id'));
        $service_seller = ServiceSeller::with(['seller'])
            ->whereHas('cities', function (Builder $query) use ($request) {
                if($request->has('city_id'))
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
