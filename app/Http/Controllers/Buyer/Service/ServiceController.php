<?php

namespace App\Http\Controllers\Buyer\Service;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\City;
use App\Models\Referral;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceQuestion;
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
use App\Models\User;
use App\Rules\Phone;
use App\Rules\ServiceRequestLocation;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\View\View;


class ServiceController extends Controller
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
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('buyer.services.index', [
            'categories' => ServiceCategory::with(['services'])->get()
        ]);
    }

    /**
     * Show the service page.
     *
     * @return mixed
     */
    public function show(Request $request, $service_slug)
    {
        $service = Service::where('slug', $service_slug)->with(['category', 'category.services', 'questions'])->firstOrFail();
        $cities = City::all();

        if(auth()->guest())
            foreach (collect(ServiceQuestion::getGuestUserQuestions())->reverse() as $q)
               $service->questions->prepend($q);

        if ($request->has('city_id')) {
            $city = City::with(['state'])->findOrFail($request->input('city_id'));

            $service_sellers = ServiceSeller::whereHas('cities', function (Builder $query) use ($request) {
                $query->where('location_id', $request->input('city_id'));
            })->where('service_id', $service->id)
                ->with(['seller'])
                ->get();
        }

        return view('buyer.services.show', [
            'service' => $service,
            'cities' => $cities,
            'city' => isset($city) ? $city : null,
            'service_sellers' => isset($service_sellers) ? $service_sellers : null
        ]);
    }
}
