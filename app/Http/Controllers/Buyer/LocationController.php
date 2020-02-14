<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CityArea;
use App\Models\Service;
use App\Models\State;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;


class LocationController extends Controller
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
     * Show the state page.
     *
     * @return \Illuminate\Http\Response
     */
    public function state($state_code)
    {
        $agent = new Agent();
        $state = State::where('state_code', $state_code)->with('cities')->firstOrFail();
        $services = $state->services()->get();
        return view('location.state', ['state' => $state, 'services' => $services, 'agent' => $agent]);
    }


    /**
     * Show the state page.
     *
     * @return \Illuminate\Http\Response
     */
    public function city($state_code, $city)
    {
        $agent = new Agent();
        $city = City::where('state_code', strtoupper($state_code))
            ->where('slug', strtolower($city))->with('state')->firstOrFail();
        $services = $city->services()->get();
        if($services->count() < 1)
            $services = $city->state->services()->get();


        return view('location.city', ['city' => $city, 'services' => $services, 'agent' => $agent, 'state' => $state_code]);
    }


    /**
     * Show the service page.
     *
     * @return \Illuminate\Http\Response
     */
    public function service($state_code, $city_slug, $service_slug)
    {
        $service = Service::where('slug', strtolower($service_slug))->with('states', 'questions')->firstOrFail();
        $city_object = City::where("slug", $city_slug)->where("state_code", $state_code)->first();
        $location = CityArea::where("city_id", $city_object->id)->with('city', 'city.state')->first();
        $city = $location->city;
        $seo_title = "$service->name in $city->city, $state_code | ". config('app.name', 'Service By ONE');
        return view('services.show',
            [
                'seo_title' => $seo_title,
                'city' => $city,
                'service' => $service,
                'location' => $location
            ]);
    }


}
