<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $service_slug)
    {
        $service = Service::where('slug', $service_slug)->with(['category', 'category.services', 'questions'])->firstOrFail();
        $cities = City::all();

        $service->questions->prepend(ServiceQuestion::where('name', 'guest.phone')->first());
        $service->questions->prepend(ServiceQuestion::where('name', 'guest.email')->first());
        $service->questions->prepend(ServiceQuestion::where('name', 'guest.name')->first());

        if($request->has('city_id'))
        {
            $city = City::with(['state'])->findOrFail($request->input('city_id'));

            $service_sellers = ServiceSeller::whereHas('cities', function (Builder $query) use ($request) {
                $query->where('location_id', $request->input('city_id'));
            })->where('service_id', $service->id)
                ->with(['seller'])
                ->get();
        }

        return $service->questions;

        return view('buyer.services.show', [
            'service' => $service,
            'cities' => $cities,
            'city' => isset($city) ? $city : null,
            'service_sellers' => isset($service_sellers) ? $service_sellers : null
        ]);
    }


    /**
     * Store request data.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = Service::with(['questions'])->findOrFail((int) $request->input('service_id'));
        $service_seller = ServiceSeller::with([])->findOrFail((int) $request->input('service_seller_id'));

        $service->questions->prepend(ServiceQuestion::where('name', 'guest.phone')->first());
        $service->questions->prepend(ServiceQuestion::where('name', 'guest.email')->first());
        $service->questions->prepend(ServiceQuestion::where('name', 'guest.name')->first());

        $validatedData = $this->validateAnswers($service, $service_seller, $request);

        $serviceRequest = ServiceRequest::create([
            'service_seller_id' => $service_seller->id,
            'buyer_id' => auth('buyer')->id(),
            'location_id' => City::find($validatedData['city_id'])->id
        ]);

        $user = new Buyer();

        foreach ($service->questions as $q)
        {
            if(isset($validatedData['answer-'.$q->id]))
            {
                if($q->auth_rule == ServiceQuestion::AUTH_REQUIRED) {
                    if (!auth('buyer')->check())
                        continue;
                }
                if($q->auth_rule == ServiceQuestion::AUTH_GUEST) {
                    if (!auth('buyer')->guest())
                        continue;
                }

                $answers = array();
                if($q->type == ServiceQuestion::TYPE_BOOLEAN)
                    $answers[] = ServiceRequestAnswerBoolean::create(['answer' => $validatedData['answer-'.$q->id]]);
                else if($q->type == ServiceQuestion::TYPE_TEXT)
                {
                    if($q->name == 'guest.name')
                        $user->name = $validatedData['answer-'.$q->id];
                    else if($q->name == 'guest.email')
                        $user->email = $validatedData['answer-'.$q->id];
                    else if($q->name == 'guest.phone')
                        $user->phone = $validatedData['answer-'.$q->id];
                    else
                        $answers[] = ServiceRequestAnswerText::create(['answer' => $validatedData['answer-'.$q->id]]);
                } else if($q->type == ServiceQuestion::TYPE_TEXT_MULTILINE)
                    $answers[] = ServiceRequestAnswerTextMultiline::create(['answer' => $validatedData['answer-'.$q->id]]);
                else if($q->type == ServiceQuestion::TYPE_SELECT)
                    $answers[] = ServiceRequestAnswerChoice::create(['choice_id' => (int) $validatedData['answer-'.$q->id]]);
                else if($q->type == ServiceQuestion::TYPE_SELECT_MULTIPLE)
                {
                    foreach ($validatedData['answer-'.$q->id] as $vd)
                        $answers[] = ServiceRequestAnswerChoice::create(['choice_id' => $vd]);
                }
                else if($q->type == ServiceQuestion::TYPE_TIME)
                    $answers[] = ServiceRequestAnswerTime::create(['answer' => $validatedData['answer-'.$q->id]]);
                else if($q->type == ServiceQuestion::TYPE_DATE)
                    $answers[] = ServiceRequestAnswerDate::create(['answer' => Carbon::parse($validatedData['answer-'.$q->id])]);
                else if($q->type == ServiceQuestion::TYPE_DATE_TIME)
                    $answers[] = ServiceRequestAnswerDateTime::create(['answer' => $validatedData['answer-'.$q->id]]);
                else if($q->type == ServiceQuestion::TYPE_FILE)
                {
                    if(isset($validatedData['answer-'.$q->id]))
                    {
                        $path = $validatedData['answer-'.$q->id]->store('public/service-requests/' . $serviceRequest->id);
                        $answers[] = ServiceRequestAnswerFile::create(['file_path' => $path]);
                    }
                }
                else if($q->type == ServiceQuestion::TYPE_FILE_MULTIPLE)
                {
                    foreach ($validatedData['answer-'.$q->id] as $vd)
                    {
                        if(isset($vd))
                        {
                            $path = $vd->store('public/service-requests/' . $serviceRequest->id);
                            $answers[] = ServiceRequestAnswerFile::create(['file_path' => $path]);
                        }
                    }
                }

                foreach($answers as $answer){
                    $serviceRequestAnswer = ServiceRequestAnswer::create([
                        'request_id' => $serviceRequest->id,
                        'question_id' => $q->id,
                        'answer_id' => $answer->id,
                        'answer_type' => get_class($answer)
                    ]);
                }
            }
        }

        if(auth()->guest())
            $this->registerAndLoginGuestUser($user, $serviceRequest);

        return view("buyer.services.success");
//        return redirect()->back()->with('status', 'Your Request have been submitted successfully!!!');
    }

    /**
     * @param Service $service
     * @param ServiceSeller $service_seller
     * @param Request $request
     * @return array
     */
    private function validateAnswers(Service $service, ServiceSeller $service_seller, Request $request)
    {
        $rules = [
            'city_id' => [
                'bail',
                'required',
                'exists:cities,id',
                Rule::exists('service_seller_location', 'location_id')->where(function ($query) use ($service_seller) {
                    $query->where('location_type', \App\Models\City::class);
                    $query->where('service_seller_id', $service_seller->id);
                }),
            ]
        ];
        foreach ($service->questions as $q)
        {
            $rules['answer-'.$q->id] = '';

            if($q->auth_rule == ServiceQuestion::AUTH_REQUIRED) {
                if (!auth()->check())
                    continue;
            }
            if($q->auth_rule == ServiceQuestion::AUTH_GUEST) {
                if (!auth()->guest())
                    continue;
            }

            if($q->is_required)
                $rules['answer-'.$q->id] .= 'required|';

            if($q->type == ServiceQuestion::TYPE_BOOLEAN)
                $rules['answer-'.$q->id] .= 'boolean';
            else if($q->type == ServiceQuestion::TYPE_TEXT) {
                if($q->name == 'guest.email')
                    $rules['answer-'.$q->id] .= 'email|unique:buyers,email';
                else if($q->name == 'guest.email')
                    $rules['answer-'.$q->id] .= [new Phone()];
                else
                    $rules['answer-'.$q->id] .= 'max:255';
            }
            else if($q->type == ServiceQuestion::TYPE_TEXT_MULTILINE)
                $rules['answer-'.$q->id] .= 'max:1000';
            else if($q->type == ServiceQuestion::TYPE_SELECT)
                $rules['answer-'.$q->id] .= 'integer|exists:service_question_choices,id';
            else if($q->type == ServiceQuestion::TYPE_SELECT_MULTIPLE){
                $rules['answer-'.$q->id] .= 'array';
                $rules['answer-'.$q->id.'.*'] = 'integer|exists:service_question_choices,id';
            }
            else if($q->type == ServiceQuestion::TYPE_TIME)
                $rules['answer-'.$q->id] .= 'date_format:"H:i"';
            else if($q->type == ServiceQuestion::TYPE_DATE)
                $rules['answer-'.$q->id] .= 'date_format:m/d/Y|after:today|before:'.Carbon::today()->addMonth(2)->toDateString();
            else if($q->type == ServiceQuestion::TYPE_DATE_TIME)
                $rules['answer-'.$q->id] .= 'date_format:"Y-m-d\TH:i"'; // 2018-01-01T01:01
            else if($q->type == ServiceQuestion::TYPE_FILE)
                $rules['answer-'.$q->id] .= 'image|max:15000';
            else if($q->type == ServiceQuestion::TYPE_FILE_MULTIPLE){
                $rules['answer-'.$q->id] .= 'array|max:10';
                $rules['answer-'.$q->id.'.*'] = 'image|max:15000';
            }
        }

        return $request->validate($rules);
    }

    /**
     * @param Buyer $user
     * @param ServiceRequest $serviceRequest
     * @return bool
     */
    private function registerAndLoginGuestUser(Buyer $user, ServiceRequest $serviceRequest)
    {
        $user->save();
        $serviceRequest->buyer_id = $user->id;
        $serviceRequest->save();

        auth('buyer')->loginUsingId($user->id);

//        if(\Cookie::get('referrer')){
//            $referrer = Buyer::find((int) \Cookie::get('referrer'));
//
//            if(!is_null($referrer))
//            {
//                Referral::create([
//                    'referee_id' => $user->id,
//                    'referrer_id' => $referrer->id,
//                    'commission' => $referrer->referral_commission
//                ]);
//            }
//        }

        $user->sendEmailVerificationNotification();

        return true;
    }
}
