<?php

namespace App\Http\Controllers\Buyer;

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


    /**
     * Store request data.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $service = Service::with(['questions'])->findOrFail((int)$request->input('service_id'));
        $service_seller = ServiceSeller::with([])->findOrFail((int)$request->input('service_seller_id'));

        $validatedData = $this->validateAnswers($service, $service_seller, $request);

        $user = auth()->check() ? auth()->user() : new Buyer();
        if (auth()->guest())
        {
            $this->registerAndLoginGuestUser($user, $validatedData);
            unset($validatedData['answer-name']);
            unset($validatedData['answer-email']);
            unset($validatedData['answer-phone']);
        }

        $serviceRequest = ServiceRequest::create([
            'service_seller_id' => $service_seller->id,
            'buyer_id' => auth('buyer')->id(),
            'location_id' => City::find($validatedData['city_id'])->id
        ]);

        foreach ($service->questions as $q) {
            $name = 'answer-' . $q->id;

            if (isset($validatedData[$name])) {
                if ($q->auth_rule->isOnlyForAuthenticatedUser()) {
                    if (!auth('buyer')->check())
                        continue;
                }
                if ($q->auth_rule->isOnlyForGuestUser()) {
                    if (!auth('buyer')->guest())
                        continue;
                }

                $answers = $q->type->saveAnswer($validatedData[$name], ['path' => 'public/service-requests/' . $serviceRequest->id]);

                foreach ($answers as $answer) {
                    $serviceRequestAnswer = ServiceRequestAnswer::create([
                        'request_id' => $serviceRequest->id,
                        'question_id' => $q->id,
                        'answer_id' => $answer->id,
                        'answer_type' => get_class($answer)
                    ]);
                }
            }
        }

        return view("buyer.services.success");
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
                    $query->where('location_type', City::class);
                    $query->where('service_seller_id', $service_seller->id);
                }),
            ]
        ];

        if(auth()->guest())
        {
            $rules['answer-name'] = 'required|string|max:100';
            $rules['answer-email'] = 'required|email|unique:users,email';
            $rules['answer-phone'] = ['required', new Phone()];
        }

        foreach ($service->questions as $q) {
            $name = 'answer-' . $q->id;
            $rules[$name] = [];

            if ($q->auth_rule->isOnlyForAuthenticatedUser()) {
                if (!auth()->check())
                    continue;
            }
            if ($q->auth_rule->isOnlyForGuestUser()) {
                if (!auth()->guest())
                    continue;
            }

            $rules = array_merge($rules, $q->type->getRules(true, $name));
        }

        return $request->validate($rules);
    }

    /**
     * @param Buyer $user
     * @param array $data
     * @return bool
     */
    private function registerAndLoginGuestUser(Buyer $user, $data)
    {
        $user->name = $data['answer-name'];
        $user->email = $data['answer-email'];
        $user->phone = $data['answer-phone'];
        $user->save();

        auth('buyer')->loginUsingId($user->id);

        $user->sendEmailVerificationNotification();

        return true;
    }
}
