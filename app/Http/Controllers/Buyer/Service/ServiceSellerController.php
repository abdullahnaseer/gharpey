<?php

namespace App\Http\Controllers\Buyer\Service;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\City;
use App\Models\Referral;
use App\Models\Service;
use App\Models\ServiceQuestion;
use App\Models\ServiceQuestionChoices;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestAnswer;
use App\Models\ServiceSeller;
use App\Models\User;
use App\Rules\Phone;
use App\Rules\ServiceRequestLocation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * @return mixed
     */
    public function show(Request $request, $service_slug, $service_seller_id)
    {
        $cities = City::all();
        $city = City::find($request->input('city_id'));

        $service_seller = ServiceSeller::with(['seller', 'reviews', 'questions'])
            ->whereHas('cities', function (Builder $query) use ($request) {
                if ($request->has('city_id'))
                    $query->where('location_id', $request->input('city_id'));
            })
            ->findOrFail($service_seller_id);
        $service = Service::where('slug', $service_slug)
            ->with(['category'])
            ->findOrFail($service_seller->service_id);

        if(auth()->guest())
        {
            foreach (ServiceQuestion::getGuestUserQuestions()->reverse() as $question)
                $service_seller->questions->prepend ($question);
        }

        return view('buyer.services.sellers.show', [
            'service' => $service,
            'service_seller' => $service_seller,
            'cities' => $cities,
            'city' => $city
        ]);
    }

    /**
     * Store request data.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request, $service_id)
    {
        $service = Service::with([])->findOrFail((int) $service_id);
        $service_seller = ServiceSeller::with(['questions'])->findOrFail((int)$request->input('service_seller_id'));

        $validatedData = $this->validateAnswers($service, $service_seller, $request);

        $user = auth()->check() ? auth()->user() : new Buyer();
        if (auth()->guest())
        {
            $this->registerAndLoginGuestUser($user, $validatedData);
            unset($validatedData['answer-name']);
            unset($validatedData['answer-email']);
            unset($validatedData['answer-phone']);
        }

        $amount = (double) $service_seller->price;

        $serviceRequest = ServiceRequest::create([
            'service_seller_id' => $service_seller->id,
            'buyer_id' => auth('buyer')->id(),
            'location_id' => City::find($validatedData['city_id'])->id
        ]);

        foreach ($service_seller->questions as $q) {
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

                $answers = $q->type->saveAnswer(
                    $validatedData[$name],
                    [
                        'path' => 'public/service-requests/' . $serviceRequest->id
                    ]
                );

                foreach ($answers as $answer) {
                    if(isset($answer->price_change) && !empty($answer->price_change))
                        $amount += (double) $answer->price_change;

                    $serviceRequestAnswer = ServiceRequestAnswer::create([
                        'request_id' => $serviceRequest->id,
                        'question_id' => $q->id,
                        'answer_id' => $answer->id,
                        'answer_type' => get_class($answer),

                        'name' => $q->name,
                        'question' => $q->question,
                        'type' => get_class($q->type),
                    ]);
                }
            }
        }

        $serviceRequest->update(['total_amount' => $amount]);

        return redirect(route("buyer.service.checkout.shipping.get", [$serviceRequest->id]));
//        return view("buyer.services.success");
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
            $rules['answer-email'] = 'required|email|unique:buyers,email';
            $rules['answer-phone'] = ['required', new Phone()];
        }

        foreach ($service_seller->questions as $q) {
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
